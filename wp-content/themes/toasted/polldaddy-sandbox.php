<?php

class PollDaddy {
    // "The partnerGUID in all requests to the Polldaddy API is the API key created in step 2 above."
    private $apiKey            = '05513340-ce60-7329-03bc-00001a6c2918';
    private $userCode          = '$P$B1cgSNOqlWOgbxvF8DcsDVen/SgV3V1';
    private $pollDaddyUsername = 'kcoolman@realtime.net';
    private $pollDaddyPassword = 'ZdF`Nf%x53wV*wZ';

    public function __construct() {
        // if the $userCode is empty, then lets generate us a new code
        if (empty($this->userCode)) {
            $this->generateUserCode();
        }
    }

    /**
     * Generates a userCode
     *
     * @return string
     */
    private function generateUserCode() {
        $data = array(
            'pdInitiate' => array(
                'partnerGUID'   => $this->apiKey,
                'partnerUserID' => '0',
                'email'         => $this->pollDaddyUsername,
                'password'      => $this->pollDaddyPassword,
            ),
        );

        $response = $this->sendJsonQuery($data);

        if ($response->pdResponse && $response->pdResponse->userCode) {
            die ('Set your userCode to <code>' . $response->pdResponse->userCode . '</code>');
        } else {
            die('Something went wrong');
        }
    }

    /**
     * Send a request to the PollDaddy Api
     *
     * @param array $data
     *
     * @return array|mixed|object
     */
    private function sendJsonQuery(array $data) {
        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.polldaddy.com/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    /**
     * Really serves as a test function, but gets the user ratings
     */
    public function getRatings() {
        $data = array(
            'pdRequest' => array(
                'partnerGUID' => $this->apiKey,
                'userCode'    => $this->userCode,
                'demands'     => array(
                    'demand' => array(
                        'list' => array(
                            'start' => '0',
                            'end'   => '5',
                        ),
                        'id'   => 'GetRatings',
                    ),
                ),
            ),
        );

        //die('<pre>' . print_r($data, 1));

        $result = $this->sendJsonQuery($data);
        die('<pre>' . print_r($result, 1));
    }

    public function createRating() {
        $data = array(
            'pdRequest' => array(
                'partnerGUID' => $this->apiKey,
                'userCode'    => $this->userCode,
                'demands'     => array(
                    'demand' => array(
                        'rating' => array(
                            'date'      => date('Y-m-d H:i:s'),
                            'name'      => 'Test review by Jameson',
                            'folder_id' => 'some folder id?',
                            'settings'  => '',
                            'type'      => '0',
                        ),
                        'id'     => 'CreateRating',
                    ),
                ),
            ),
        );

        die('<pre>' . print_r($data, 1));
    }

    public function getFrontEndRating($wp_id) {
        $someId = 7999183;
        $url = 'http://polldaddy.com/ratings/rate.php';
        $return = (object)array(
            'avg_rating' => null,
            'votes' => null,
            'token' => null,
            'extra' => null,
        );

        // any GET parameters we need to pass
        $params = array(
            'cmd' => 'get',
            'id' => $someId,
            'uid' => 'wp-post-' . $wp_id,
            'item_id' => '_post_' . $wp_id,
        );

        // if we have some parameters, lets clean them up
        if (count($params)) {
            $url = $url .'?';

            foreach($params as $key => $val) {
                $url .= $key . '=' . $val . '&';
            }

            $url = rtrim($url, '&');
        }

        // setup the curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        curl_close($ch);

        echo '<pre>' . print_r($data, 1);

        // extract the avg_rating
        $matches = array();
        preg_match_all('/\.avg_rating ?= ?([0-9]);/', $data, $matches);

        if (isset($matches[1]) && isset($matches[1][0])) {
            $return->avg_rating = $matches[1][0];
        }

        // extract the votes
        $matches = array();
        preg_match_all('/\.votes ?= ?([0-9]+);/', $data, $matches);

        if (isset($matches[1]) && isset($matches[1][0])) {
            $return->votes = $matches[1][0];
        }

        // extract the token
        $matches = array();
        preg_match_all('/\.token=\'([0-9a-z]+)\'/', $data, $matches);

        if (isset($matches[1]) && isset($matches[1][0])) {
            $return->token = $matches[1][0];
        }

        // extract extra
        $matches = array();
        preg_match_all('/\/\*([0-9a-z-_,]+)/i', $data, $matches);

        if (isset($matches[1]) && isset($matches[1][0])) {
            $return->extra = $matches[1][0];
        }

        return $return;
    }
}

include($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'wp-blog-header.php');

$wordpressId = 91715;
$post = get_post($wordpressId);
$postMeta = get_post_meta($wordpressId);

$pollDaddy = new PollDaddy();
$test = $pollDaddy->getFrontEndRating($wordpressId);

//die('<pre>' . print_r($test, 1));
//die('<pre>' . print_r($post, 1));

/*
 * Array
(
    [avg_rating] => 2
    [votes] => 298
    [token] => b79fd1e5b0745eeebf85681bd2def76d
)
 */

$testExtra = explode(',' ,$test->extra);

$cmd = 'change';
$vote = '3';

$data = array(
    'title' => urlencode($post->post_title),
    'permalink' => get_permalink($wordpressId),
    'type' => 'stars',
    'id' => $testExtra[0],
    'r' => $vote,
    'uid' => $testExtra[2],
    'item_id' => $testExtra[1],
    'votes' => $test->votes,
    'avg' => $test->avg_rating,
    'cmd' => $cmd,
    'vid' => $testExtra[3],
    'token' => $test->token,
);

die('<pre>' . print_r($data, 1));
/*
 * title:BATMAN%20V%20SUPERMAN%20-%20Double%20Toasted%20Audio%20Review
permalink:http://kcoolman.staging.wpengine.com/show/batman-v-superman-double-toasted-audio-review/
type:stars
id:7999183
r:3
uid:wp-post-91715
item_id:_post_91715
votes:277
avg:2
cmd:change
vid:800479186
token:b0c9ef325a47adacabf2b7ca1a3905b5
 */
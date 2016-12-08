<?php

/*
Controller name: Contact Contact API
Controller description: Integrates to Constant Contact
*/

class JSON_API_Ccemail_Controller {
    protected $listId = '1077785891';
    protected $apiKey = 'zzwgnq4hkar9nsnrqetctdvp';
    protected $bearer = '7bc48b03-d84b-46ed-a3ba-fb80fda73fd1';

    private $email;
    private $useListId;
    private $checkExists = false;

    private function init() {
        global $json_api;

        if (empty($this->email) && empty($this->useListId)) {
            $listId = $json_api->query->list_id;
            $email  = urldecode($json_api->query->email);

            // if we didn't pass a listid, default to the subscription form id
            if (empty($listId)) {
                $listId = $this->listId;
            }

            if (empty($email)) {
                return $this->returnBadEmail();
            }

            if (empty($listId)) {
                return $this->returnBadList();
            }

            $this->email = $email;
            $this->useListId = $listId;
        }

        $this->checkExists = $json_api->query->check_exists;
    }

    public function on_list() {
        $this->init();

        // setup two arrays, params for the GET and the headers
        $params  = array(
            'api_key' => $this->apiKey,
            'email'   => $this->email,
        );
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->bearer,
        );

        // base url
        $url = 'https://api.constantcontact.com/v2/contacts';

        // append any query string parameters 
        if (count($params)) {
            $url .= '?';

            foreach ($params as $field => $value) {
                $url .= $field . '=' . $value . '&';
            }

            $url = rtrim($url, '&');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        // parse the results
        $isOnList = false;

        if ($result->results) {
            if ($lists = $result->results[0]->lists) {
                foreach ($lists as $list) {
                    if ($list->id == $this->useListId) {
                        $isOnList = true;
                        break;
                    }
                }
            }
        }

        return array(
            'result' => $isOnList,
        );
    }

    public function register_list() {
        $this->init();

        $url = 'https://visitor2.constantcontact.com/api/signup';

        if ($this->checkExists) {
            $onListcheck = $this->on_list();

            if ($onListcheck['result']) {
                return $this->returnAlreadyExists();
            }
        }

        // set the post fields
        $params = array(
            'ca'       => 'cee3fe15-a231-484f-ace4-32c430b07a4c',
            'email'    => $this->email,
            'source'   => 'EFD',
            'list'     => $this->useListId,
            'required' => 'list,email',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        
        if ($result->success) {
            return $this->returnCongratulations();
        } else {
            if ($offenders = $result->offenders) {
                $isEmailBad = false;
                
                foreach($offenders as $offender) {
                    if ($offender->offender == 'email') {
                        $isEmailBad = true;
                        break;
                    }
                }
                
                if ($isEmailBad) {
                    return $this->returnBadEmail();
                }
            }
        }

        return $this->returnUnknownError();
    }

    private function returnUnknownError() {
        return array(
            'result' => 'Unknown error occurred.',
            'clearField' => false,
        );
    }

    private function returnBadEmail() {
        return array(
            'result' => 'This is not a valid email address.',
            'clearField' => false,
        );
    }

    private function returnCongratulations() {
        return array(
            'result' => 'Congratulations! You\'ve just subscribed.',
            'clearField' => true,
        );
    }

    private function returnBadList() {
        return array(
            'result' => 'This is not a valid list id.',
            'clearField' => false,
        );
    }
    private function returnAlreadyExists() {
        return array(
            'result' => 'We already have your email.',
            'clearField' => false,
        );
    }

}
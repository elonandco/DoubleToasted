<?php
$url = 'http://api.gigcasters.com/api/live_shows?start_date=2000-01-01&end_date=2036-01-01&key=8e997829a08d104713a97b6ada431d37c5afb0f4';
$ch  = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);

$result = curl_exec($ch);
curl_close($ch);
$gigcasterData = json_decode($result);

//die('<pre>' . print_r($gigcasterData, 1). '</pre>');
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gigcaster Stuff</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <style>
        .bold {
            font-weight: bold;
            padding-right: 10px;
        }
    </style>

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <ul>
        <?php foreach($gigcasterData->result as $result): ?>
            <li>
                <a href="http://ppv.gigcasters.com/embed/<?php echo $result->show_sku; ?>.html" target="_blank"><?php echo $result->show_sku; ?></a>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <table>
                                <tr>
                                    <td class="bold">site:</td>
                                    <td><?php echo $result->site; ?></td>
                                    </tr>
                                <tr>
                                    <td class="bold">start time:</td>
                                    <td><?php echo $result->start_time; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">stop time:</td>
                                    <td><?php echo $result->stop_time; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">price:</td>
                                    <td><?php echo $result->price; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">featured_show:</td>
                                    <td><?php echo $result->featured_show; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">teaser_image:</td>
                                    <td>
                                        <?php if ($result->teaser_image_url): ?>
                                            <a href="<?php echo $result->teaser_image_url; ?>" target="_blank">image</a>
                                        <?php else: ?>
                                            no image
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">artist:</td>
                                    <td><?php echo $result->artist; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">description:</td>
                                    <td><?php echo $result->description; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">preview_video_url:</td>
                                    <td><?php echo $result->preview_video_url; ?></td>
                                </tr>
                            </table>
                        </td>

                        <td width="50%">
                            <table>
                                <tr>
                                    <td class="bold">show_url:</td>
                                    <td><a href="<?php echo $result->show_url; ?>" target="_blank"><?php echo $result->show_url; ?></a></td>
                                </tr>
                                <tr>
                                    <td class="bold">device_purchase_url:</td>
                                    <td><a href="<?php echo $result->device_purchase_url; ?>" target="_blank"><?php echo $result->device_purchase_url; ?></a></td>
                                </tr>
                                <tr>
                                    <td class="bold">server:</td>
                                    <td><?php echo $result->server; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">show_ad:</td>
                                    <td><?php echo $result->show_ad; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">preview_duration:</td>
                                    <td><?php echo $result->preview_duration; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">max_concurrent_sessions:</td>
                                    <td><?php echo $result->max_concurrent_sessions; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">uhd:</td>
                                    <td><?php echo $result->uhd; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">vod:</td>
                                    <td><?php echo $result->vod; ?></td>
                                </tr>
                                <tr>
                                    <td class="bold">public:</td>
                                    <td><?php echo $result->public; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </li>
        <?php endforeach; ?>
    </ul>

</div><!-- /.container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
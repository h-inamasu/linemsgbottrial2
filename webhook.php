<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = "Aqz5BrhjfO/KVVKNbWs53JAqw6I72LW70UkXKIEBjnnimWfznIRlLmD90hQrWx1cd2fpIAvMEPDBhCrTjBUpIlB0lHmVLMlWB0+voyhjocU8uK8QCr/wKDnuDtnd2YSUhMt4Nxl2Q+j7EBA2LHwVdwdB04t89/1O/w1cDnyilFU=";
$channelSecret = "2332badaa8b3f765fbb60ebbe12041d0";

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
		            if (strcmp($message['text'],"テキスト")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => $message['text']
                                )
                            )
                        ));
		            } else if (strcmp($message['text'],"スタンプ")==0) {
                        $reply_token=$event['replyToken'];
                        $header=array('Content-Type: application/json',
                                      'Autorization: Bear ' . $client->channelAccessToken);
                        $message=array('type'=>'sticker',
                                       'packageId'=>1,
                                       'stickerId'=>1);
                        $body=json_encode(array('replyToken'=>$reply_token,
                                                'messages'=>array($message)));
                        $options=array(CURLOPT_URL=>'https://api.line.me/v2/bot/message/reply',
                                       CURLOPT_CUSTOMREQUEST=>'POST',
                                       CURLOPT_RETURNTRANSFER=>true,
                                       CURLOPT_HTTPHEADER=>$header,
                                       CURLOPT_POSTFIELDS=>$body);
                        $curl=curl_init();
                        curl_setopt_array($curl,$options);
                        curl_exec($curl);
                        curl_close($curl);
                    }
                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};

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
                                    //'text' => $message['text']
                                    'text' => 'テキスト応答です。'
                                )
                            )
                        ));
		            } else if (strcmp($message['text'],"スタンプ")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'sticker',
                                    'packageId' => 1,
                                    'stickerId'=>1
                                )
                            )
                        ));

                    } else if (strcmp($message['text'],"イメージ")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'image',
                                    'originalContentUrl' => 'https://linemsgbottrial2.herokuapp.com/images/image1.jpg',
                                    'previewImageUrl' => 'https://linemsgbottrial2.herokuapp.com/images/image2.jpg'
                                )
                            )
                        ));
                    } else if (strcmp($message['text'],"ビデオ")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'video',
                                    'originalContentUrl' => 'https://linemsgbottrial2.herokuapp.com/videos/video1.mp4',
                                    'previewImageUrl' => 'https://linemsgbottrial2.herokuapp.com/videos/preview1.jpg'
                                )
                            )
                        ));
                    } else if (strcmp($message['text'],"オーディオ")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'audio',
                                    'originalContentUrl' => 'https://linemsgbottrial2.herokuapp.com/audios/audio1.mp3',
                                    'duration' => 5000
                                )
                            )
                        ));
                    } else if (strcmp($message['text'],"ロケーション")==0) {
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'location',
                                    'title' => '皇居',
                                    'address' => '〒100-8111 東京都千代田区千代田１−１',
                                    'latitude' => 35.683798,
                                    'longitude' => 139.754182
                                )
                            )
                        ));
                    } else if (strcmp($message['text'],"ボタンテンプレート")==0) {
                        $template = array('type'    => 'buttons',
                                          'thumbnailImageUrl' => 'https://linemsgbottrial2.herokuapp.com/images/image1.jpg',
                                          'title'   => 'タイトル最大40文字' ,
                                          'text'    => 'テキストメッセージ。タイトルがないときは最大160文字、タイトルがあるときは最大60文字',
                                          'actions' => array(
                                                    array('type'=>'message', 'label'=>'ラベル', 'text'=>'アクションを実行した時に送信されるメッセージ' ))
                                                                                                                                                         );
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'template',
                                    'altText' => '代替えテキスト',
                                    'template' => $template
                                )
                            )
                        ));
                    } else if (strcmp($message['text'],"確認テンプレート")==0) {
                        $template = array('type'    => 'confirm',
                                          'text'    => 'テキストメッセージ。最大240文字',
                                          'actions' => array(
                                                        array('type'=>'message', 'label'=>'yes', 'text'=>'yesを押しました' ),
                                                        array('type'=>'message', 'label'=>'no',  'text'=>'noを押しました' )
                                                                                                                                                        )
                                                                                                                                                      );
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'template',
                                    'altText' => '代替えテキスト',
                                    'template' => $template
                                )
                            )
                        ));
                    /*
                    } else if (strcmp($message['text'],"カルーセルテンプレート")==0) {
                        $columns=array(
                                    array('thumbnailImageUrl'=>'https://linemsgbottrial2.herokuapp.com/images/image1.jpg',
                                          'title' => 'タイトル1',
                                          'text' => 'テキスト1',
                                          'actions' => array(array('type'=>'message','label'=>'ラベル','text'=>'メッセージ'))
                                          )
                                          );
                        $template=array('type'=>'image_carousel',
                                        'columns' => $columns,
                                        );
                                     );
                        $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'template',
                                    'altText' => '代替えテキスト',
                                    'template' => $template
                                )
                            )
                        ));
                    */
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

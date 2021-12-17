<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Access_token;
use App\Funtap;
use App\Botchat;

class DemoConversation extends Controller
{
    protected $firstname;

    protected $email;

    public function webhook(Request $request)
    {
        Log::debug("webhook data:", $request->all());
        if ($request->input("hub_mode") === "subscribe" && $request->input("hub_verify_token") === env("MESSENGER_VERIFY_TOKEN")) {
            return response($request->input("hub_challenge"), 200);
        }
    }
    public function addWebhook(Request $request)
    {
        $messages = $request->input();
        Log::debug($request->input());
        $idSender = $messages["entry"][0]["messaging"][0]["sender"]["id"];
        $id_page = $messages['entry'][0]['messaging'][0]['recipient']['id'];
        $chat = new Botchat();
        $chat->chat = $messages['entry'][0]['messaging'][0]['postback']['title'];
        $chat->id_page = $messages['entry'][0]['messaging'][0]['recipient']['id'];
        $chat->time = $messages['entry'][0]['messaging'][0]['timestamp'];
        $chat->id_user = $messages['entry'][0]['messaging'][0]['sender']['id'];
        $chat->save();
        $funtap_title_token = Funtap::where('id_page', $id_page)
            ->where('id_dad', 0)
            ->where('funtaps.deleted_at', null)
            ->where('access_tokens.deleted_at', null)
            ->join('titles', 'titles.id_funtap', '=', 'funtaps.id')
            ->join('access_tokens', 'access_tokens.id', '=', 'funtaps.id_token')->select('funtaps.id')->get();
        $title_funtap = Funtap::join('titles', 'titles.id_funtap', '=', 'funtaps.id')->get();
        if ($messages['entry'][0]['messaging'][0]['postback']['title'] == 'Get Started') {
            $sss = [];
            foreach ($funtap_title_token as $value) {
                $sss[] = $value->id;
            }
            $this->sendTextMessage($idSender, $id_page, 'Get Started', '', $sss[0]);
        }
        foreach ($title_funtap as $value) {
            if ($messages['entry'][0]['messaging'][0]['postback']['title'] == $value->title) {
                $this->sendTextMessage($idSender, $id_page, $value->title, $value->id, $value->id_funtap);
            }
        }
    }
    private function sendTextMessage($recipientId, $id_page, $messageText, $id_title, $id_funtap)
    {
        $title_funtap = Access_token::where('funtaps.id', $id_funtap)->where('id_page', $id_page)->join('funtaps', 'funtaps.id_token', '=', 'access_tokens.id')->get();
        $sender = [
            "recipient" => [
                "id" => $recipientId,
            ],
            "sender_action" => "typing_on",
        ];
        if ($messageText == 'Get Started') {
            $funtap_title_token = Funtap::where('titles.deleted_at', null)
                ->where('id_dad', 0)->where('id_page', $id_page)
                ->join('titles', 'titles.id_funtap', '=', 'funtaps.id')
                ->join('access_tokens', 'access_tokens.id', '=', 'funtaps.id_token')->get();
        } else {
            $funtap_title_token = Funtap::where('titles.deleted_at', null)
                ->where('id_dad', $id_title)->where('id_page', $id_page)
                ->join('titles', 'titles.id_funtap', '=', 'funtaps.id')
                ->join('access_tokens', 'access_tokens.id', '=', 'funtaps.id_token')->get();
        }
        foreach ($funtap_title_token as $value) {
            $text = [
                "recipient" => [
                    "id" => $recipientId,
                ],
                "message" => [
                    "text" => $value->content,
                ],
            ];
        }

        foreach ($title_funtap as $value) {
            $ch = curl_init("https://graph.facebook.com/v12.0/me/messages?access_token=$value->token");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sender));
            curl_exec($ch);
            curl_close($ch);

            $ch = curl_init("https://graph.facebook.com/v12.0/me/messages?access_token=$value->token");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($text));
            curl_exec($ch);
            curl_close($ch);
        }
        $bt = [];
        foreach ($funtap_title_token as $value) {
            if ($value->url == Null) {
                $bt[] = [
                    "title" => $value->title,
                    "type" => "postback",
                    "payload" => "DEVELOPER_DEFINED_PAYLOAD"
                ];
            } else {
                $bt[] = [
                    "title" => $value->title,
                    "type" => "web_url",
                    "url" => $value->url,
                ];
            }
        }
        $t = count($funtap_title_token);
        if ($t <= 2) {
            Log::debug(1);
            $button = $bt;
            foreach ($funtap_title_token as $value) {
                $element = [
                    [
                        "title" => $value->title_element,
                        "image_url" => $value->image_url,
                        "subtitle" => $value->subtitle,
                        "buttons" => $button
                    ]
                ];
            }
            $messageData = [
                "recipient" => [
                    "id" => $recipientId,
                ],
                "message" => [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "generic",
                            "elements" => $element,
                        ],
                    ]
                ],
            ];
            Log::debug($messageData);
            $title_funtap = Access_token::where('funtaps.id', $id_funtap)->where('id_page', $id_page)->join('funtaps', 'funtaps.id_token', '=', 'access_tokens.id')->get();
            foreach ($title_funtap as $value) {
                $ch = curl_init("https://graph.facebook.com/v12.0/me/messages?access_token=$value->token");
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
                curl_exec($ch);
                curl_close($ch);
            }
        } else {
            $button = array_chunk($bt, 2);
            for ($i = 0; $i < count($button); $i++) {
                foreach ($funtap_title_token as $value) {
                    $element = [
                        [
                            "title" => $value->title_element,
                            "image_url" => $value->image_url,
                            "subtitle" => $value->subtitle,
                            "buttons" => $button[$i]
                        ]
                    ];
                }
                $messageData = [
                    "recipient" => [
                        "id" => $recipientId,
                    ],
                    "message" => [
                        "attachment" => [
                            "type" => "template",
                            "payload" => [
                                "template_type" => "generic",
                                "elements" => $element,
                            ],
                        ]
                    ],
                ];
                $title_funtap = Access_token::where('funtaps.id', $id_funtap)->where('id_page', $id_page)->join('funtaps', 'funtaps.id_token', '=', 'access_tokens.id')->get();
                foreach ($title_funtap as $value) {
                    $ch = curl_init("https://graph.facebook.com/v12.0/me/messages?access_token=$value->token");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
                    curl_exec($ch);
                    curl_close($ch);
                }
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TestSlack;
use Illuminate\Http\Request;
use App\Models\ThongTinSuKien;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    // public function get() {
    //     $suKien = new ThongTinSuKien();
    //     $suKien->dsTrangThai;
    // }

    public function create(){
        return view('test-slack.create');
    }
    public function guiForm(Request $request){

        $validated = $request->validate([
            'ho_ten' => ['required'],
            'ngay_sinh' => ['required'],
            'email' => ['required'],
            'so_dien_thoai' => ['required'],


        ]);

            $webhook = 'https://hooks.slack.com/services/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';

            $payload = [
                "blocks" => [

                    [
                        "type" => "section",
                        "text" => [
                            "type" => "mrkdwn",
                            "text" => "*📋 Khách hàng đăng ký:*"
                        ]
                    ],
                    [
                        "type" => "section",
                        "fields" => [
                            [
                                "type" => "mrkdwn",
                                "text" => "*Họ tên:*\n{$validated['ho_ten']}"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Email:*\n{$validated['email']}"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Ngày sinh:*\n{$validated['ngay_sinh']}"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Số điện thoại:*\n{$validated['so_dien_thoai']}"
                            ]
                        ]
                    ],
                    [
                        "type" => "actions",
                        "elements" => [
                            [
                                "type" => "button",
                                "text" => [
                                    "type" => "plain_text",
                                    "text" => "✅ Duyệt"
                                ],
                                "style" => "primary",
                                "value" => json_encode([
                                    'action' => 'duyet',
                                    'ho_ten' => $validated['ho_ten'],
                                    'ngay_sinh' => $validated['ngay_sinh'],
                                    'email' => $validated['email'],
                                    'so_dien_thoai' => $validated['so_dien_thoai'],
                                ])
                            ],
                            [
                                "type" => "button",
                                "text" => [
                                    "type" => "plain_text",
                                    "text" => "❌ Từ chối"
                                ],
                                "style" => "danger",
                                "value" => "tu_choi"
                            ]
                        ]
                    ]
                ]
            ];

            // Gửi POST request tới Slack webhook
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($webhook, $payload);

            if ($response->successful()) {
                return "Gửi thành công!";
            } else {
                return "Gửi thất bại: " . $response->body();
            }
    }


    public function store(Request $request){
        // Slack gửi về JSON qua biến "payload"
        $payload = json_decode($request->input('payload'), true);

        // Lấy giá trị nút bấm
        $action = $payload['actions'][0] ?? null;

        if (!$action) {
            return response('Không có hành động nào.', 400);
        }

        $value = json_decode($action['value'], true);

        if ($value['action'] === 'duyet') {
            // Lưu vào DB
            DuyetKhachHang::create([
                'ho_ten' => $value['ho_ten'],
                'email' => $value['email'],
                'ngay_sinh' => $value['ngay_sinh'],
                'so_dien_thoai' => $value['so_dien_thoai'],
                'json_data' => $payload, // Lưu toàn bộ payload để debug
            ]);

            // Trả lời Slack (hiện ra tại tin nhắn người nhấn)
            return response()->json([
                "response_type" => "ephemeral", // chỉ người bấm thấy
                "text" => "✅ *Đã lưu thông tin khách hàng thành công!*"
            ]);
        }

        return response()->json([
            "response_type" => "ephemeral",
            "text" => "❌ Không xác định được hành động."
        ]);

    }
}

<?php

class WhatsAppController {

    private $verify_token = "0c6Yq1Rva5JtoMvKptmT5O7evtGrF5I4xj610RLl8fQuYprMsaD8dtFy4VhW35cj"; // ponlo tú

    public function verify() {
        $mode = $_GET['hub_mode'] ?? '';
        $token = $_GET['hub_verify_token'] ?? '';
        $challenge = $_GET['hub_challenge'] ?? '';

        if ($mode === 'subscribe' && $token === $this->verify_token) {
            http_response_code(200);
            echo $challenge;
        } else {
            http_response_code(403);
            echo 'Forbidden';
        }
    }

    public function handleMessage() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) return;

        $entry = $input['entry'][0] ?? null;
        $changes = $entry['changes'][0] ?? null;
        $value = $changes['value'] ?? null;
        $messages = $value['messages'][0] ?? null;

        if ($messages) {
            $from = $messages['from'];
            $text = $messages['text']['body'] ?? '';

            // Aquí procesas el mensaje
            // Por ahora solo logueamos
            file_put_contents(
                __DIR__ . '/../whatsapp_log.txt',
                date('Y-m-d H:i:s') . " - De: $from - Mensaje: $text\n",
                FILE_APPEND
            );
        }

        http_response_code(200);
        echo json_encode(['status' => 'ok']);
    }
}
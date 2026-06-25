<?php
require_once "controllers/whatsapp.controller.php";

$wa = new WhatsAppController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $wa->verify();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wa->handleMessage();
}
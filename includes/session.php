<?php
class Session {
    // Démarre la session si ce n'est pas déjà fait
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Détruit la session courante
    public static function destroy() {
        if (session_status() !== PHP_SESSION_NONE) {
            // Efface le tableau $_SESSION
            $_SESSION = [];
            session_destroy();
        }
    }
}
?>

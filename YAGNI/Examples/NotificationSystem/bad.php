<?php

namespace YAGNI\Examples\NotificationSystem;

class NotificationSystem
{
    /**
     * Over-prepared for features that aren't requested yet.
     */
    public function sendNotification(
        string $message, 
        string $userId, 
        string $priority = 'low', 
        array $metadata = [],
        bool $retry = true,
        int $retryLimit = 3,
        ?string $callbackUrl = null
    ): void {
        // We only need simple email notification now, 
        // but we're building infrastructure for push, SMS, webhook callbacks, 
        // retry queues, and priority handling that isn't needed.
        
        $this->logToComplexInfrastructure($message, $userId, $priority, $metadata);
        
        if ($retry) {
            // Complex retry logic...
        }
        
        // Actually only sends email:
        mail($userId . "@example.com", "Notification", $message);
    }

    private function logToComplexInfrastructure($m, $u, $p, $meta) { /* ... */ }
}

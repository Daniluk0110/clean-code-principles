<?php

namespace RefactoringKata\Dirty;

class CustomerReport
{
    /**
     * This class is messy and generates a report directly in the service.
     */
    public function generate(array $customers): string
    {
        $html = "<html><body>";
        $html .= "<h1>Customer Report</h1>";
        $html .= "<table>";
        $html .= "<tr><th>Name</th><th>Email</th><th>Total Spent</th></tr>";

        foreach ($customers as $customer) {
            $totalSpent = 0;
            foreach ($customer['orders'] as $order) {
                if ($order['status'] === 'completed') {
                    $totalSpent += $order['amount'];
                }
            }

            $html .= "<tr>";
            $html .= "<td>" . $customer['name'] . "</td>";
            $html .= "<td>" . $customer['email'] . "</td>";
            $html .= "<td>" . $totalSpent . " " . $customer['currency'] . "</td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        $html .= "</body></html>";

        // Save to file
        file_put_contents('report.html', $html);

        return $html;
    }
}

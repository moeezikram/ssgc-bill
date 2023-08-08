<?php
    if (isset($_GET['consumer_id'])) {
        $consumerId = $_GET['consumer_id'];
  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://suigasbill.pk/view-ssgc-bill/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "ref=" . $consumerId);
        $html = curl_exec($ch);
        curl_close($ch);
  
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
  
        $data = [];
        $labelsMapping = [
            'Name' => 'name',
            'Customer Number:' => 'customer_no',
            'Billing Month:' => 'billing_month',
            'Due Date:' => 'due_date',
            'Amount Payable Within Due Date:' => 'amount_payable_indue',
            'Late Payment Surcharge:' => 'late_payment_charge',
            'Payable After Due Date:' => 'amount_payable_afterdue'
        ];
  
        $nodes = $xpath->query("//div[@class='row' or contains(@class, 'row-shaded')]");
        foreach ($nodes as $node) {
            $labelNode = $xpath->query(".//strong", $node);
            $valueNode = $xpath->query(".//div[@style='font-size:1.2em']", $node);
            
            if ($labelNode->length > 0 && $valueNode->length > 0) {
                $label = trim($labelNode->item(0)->nodeValue);
                $value = trim($valueNode->item(0)->nodeValue);
  
                if (array_key_exists($label, $labelsMapping)) {
                    $dataKey = $labelsMapping[$label];
                    $data[$dataKey] = $value;
                }
            }
        }
  
        $billUrlNodes = $xpath->query("//a[@class='fullbill']/@href");
        if ($billUrlNodes->length > 0) {
            $bill_url = trim($billUrlNodes->item(0)->nodeValue);
        }
        
        $data['bill_url'] = $bill_url;
        
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
  
  
    } else {
        echo "Consumer ID not provided";
    }
?>

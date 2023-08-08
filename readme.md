# SSGC Bill Fetcher API

This project provides an API that fetches the SSGC Bill details for a given consumer ID.

## 📌 Endpoints

- `https://moeezikram.com/api/ssgc-bill?consumer_id=<YOUR_CONSUMER_ID>`

> 🔔 **Note:** Replace `<YOUR_CONSUMER_ID>` with the desired consumer ID.

## 📄 Sample Data

When you access the API with a valid consumer ID, it will return a JSON object containing bill details like:

```json
{
  "name": "MUHAMMAD IRFAN AHMED KHAN",
  "customer_no": "5687436293",
  "billing_month": "July, 2023",
  "due_date": "21-Aug-2023",
  "amount_payable_indue": "Rs. 800",
  "late_payment_charge": "Rs. 80",
  "amount_payable_afterdue": "Rs. 880",
  "bill_url": "https://viewbill.ssgc.com.pk/web/billpdfs/sample.pdf"
}
```

## 🖥 Using with JavaScript

You can fetch this data in your JavaScript application using the following function:

```js
function fetchData(consumer_id) {
    const url = "https://moeezikram.com/api/ssgc-bill?consumer_id=" + consumer_id;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error("There was an error fetching data:", error);
    });
}

fetchData("your_consumer_id_here");
```

**🔔 Note: Replace "your_consumer_id_here" with the actual consumer_id you wish to use.**

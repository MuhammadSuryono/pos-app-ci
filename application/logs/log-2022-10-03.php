INFO - 2022-10-03 03:43:54 --> Config Class Initialized
INFO - 2022-10-03 03:43:54 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:43:54 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:43:54 --> Utf8 Class Initialized
INFO - 2022-10-03 03:43:54 --> URI Class Initialized
INFO - 2022-10-03 03:43:54 --> Router Class Initialized
INFO - 2022-10-03 03:43:54 --> Output Class Initialized
INFO - 2022-10-03 03:43:54 --> Security Class Initialized
DEBUG - 2022-10-03 03:43:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:43:54 --> Input Class Initialized
INFO - 2022-10-03 03:43:54 --> Language Class Initialized
INFO - 2022-10-03 03:43:54 --> Loader Class Initialized
INFO - 2022-10-03 03:43:54 --> Helper loaded: url_helper
INFO - 2022-10-03 03:43:54 --> Helper loaded: form_helper
INFO - 2022-10-03 03:43:54 --> Helper loaded: html_helper
INFO - 2022-10-03 03:43:54 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:43:54 --> Controller Class Initialized
INFO - 2022-10-03 03:43:59 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/NoSeriesLines?$filter=Series_Code%20eq%20'S-CR', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/NoSeriesLines","value":[{"@odata.etag":"W/\"JzE5OzQzODIxNDA2NzIxMzYzODQ0NjcxOzAwOyc=\"","Series_Code":"S-CR","Line_No":10000,"Starting_Date":"2022-01-01","Starting_No":"MKSSCM-2301-00001","Ending_No":"","Last_Date_Used":"2022-10-02","Last_No_Used":"MKSSCM-2301-00012","Warning_No":"","Increment_by_No":1,"Allow_Gaps_in_Nos":false,"Open":true}]}
INFO - 2022-10-03 03:44:00 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesOrders, BODY: {"no":"MKSSCM-2301-00013","DocumentType":"Credit Memo","PostingDate":"2022-10-03","sellToCustomerNo":"001","sellToCustomerName":"Cibubur POS","shipmentDate":"2022-10-03","ExternalDocNo":"MKSSI-2201-00029","PaymentMethod":"CASH","POSTransTime":"03:10:43","Appliestodoctype":"Invoice","Appliestodocno":"MKSSI-2201-00029"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesOrders/$entity","@odata.etag":"W/\"JzE4OzMxNTEwMTgxMDEzNjMxNTc2NDE7MDA7Jw==\"","no":"MKSSCM-2301-00013","Id":"03258e76-9342-ed11-946f-002248570eab","DocumentType":"Credit Memo","PostingDate":"2022-10-03","sellToCustomerNo":"001","sellToCustomerName":"Cibubur POS","shipmentDate":"2022-10-03","ExternalDocNo":"MKSSI-2201-00029","PaymentMethod":"CASH","POSTransTime":"03:10:43","Appliestodoctype":"Invoice","Appliestodocno":"MKSSI-2201-00029"}
INFO - 2022-10-03 03:44:01 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesLines, BODY: {"DocumentType":"Credit Memo","DocumentNo":"MKSSCM-2301-00013","lineNo":10000,"type":"Item","no":"SLQB-2208-006","description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","unitOfMeasure":"Bottle","LocationCode":"MKS03","quantity":1,"unitPrice":25000,"DiscountAmount":0}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/apiSalesLines/$entity","@odata.etag":"W/\"JzIwOzE0MTcyMTQ1NTQyNDY4MDczMTI0MTswMDsn\"","DocumentType":"Credit Memo","DocumentNo":"MKSSCM-2301-00013","lineNo":10000,"Id":"05258e76-9342-ed11-946f-002248570eab","type":"Item","no":"SLQB-2208-006","description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","unitOfMeasure":"Bottle","LocationCode":"MKS03","quantity":1,"unitPrice":25000,"DiscountAmount":0}
INFO - 2022-10-03 03:44:02 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment?$filter=SalesOrderNo%20eq%20'MKSSI-2201-00029', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment","value":[{"@odata.etag":"W/\"JzE5OzE2NDk1MjI2NDQ5NTE4NDM2MjMxOzAwOyc=\"","Entry_No":3,"SalesOrderNo":"MKSSI-2201-00029","PaymentMethodCode":"DB OT BCA","NominalPayment":25000,"PaymentType":"DEBIT","QtyPoint":0,"NoNOTA":"","DeliveryAmount":0}]}
INFO - 2022-10-03 03:44:03 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment, BODY: {"SalesOrderNo":"MKSSCM-2301-00013","PaymentMethodCode":"DB OT BCA","NominalPayment":-25000,"PaymentType":"DEBIT","QtyPoint":0,"NoNOTA":"","DeliveryAmount":0}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Payment/$entity","@odata.etag":"W/\"JzE5OzUwNDkwOTc0MTM0Njk1Mjk0NTQxOzAwOyc=\"","Entry_No":1028,"SalesOrderNo":"MKSSCM-2301-00013","PaymentMethodCode":"DB OT BCA","NominalPayment":-25000,"PaymentType":"DEBIT","QtyPoint":0,"NoNOTA":"","DeliveryAmount":0}
INFO - 2022-10-03 03:44:06 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/POS_Integration_PostingCrMemo?Company=MKS%20DEMO, BODY: {"crMemoNo":"MKSSCM-2301-00013"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Edm.String","value":""}
INFO - 2022-10-03 03:44:06 --> Final output sent to browser
DEBUG - 2022-10-03 03:44:06 --> Total execution time: 11.9535
INFO - 2022-10-03 03:44:29 --> Config Class Initialized
INFO - 2022-10-03 03:44:29 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:44:29 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:44:29 --> Utf8 Class Initialized
INFO - 2022-10-03 03:44:29 --> URI Class Initialized
INFO - 2022-10-03 03:44:29 --> Router Class Initialized
INFO - 2022-10-03 03:44:29 --> Output Class Initialized
INFO - 2022-10-03 03:44:29 --> Security Class Initialized
DEBUG - 2022-10-03 03:44:29 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:44:29 --> Input Class Initialized
INFO - 2022-10-03 03:44:29 --> Language Class Initialized
INFO - 2022-10-03 03:44:30 --> Loader Class Initialized
INFO - 2022-10-03 03:44:30 --> Helper loaded: url_helper
INFO - 2022-10-03 03:44:30 --> Helper loaded: form_helper
INFO - 2022-10-03 03:44:30 --> Helper loaded: html_helper
INFO - 2022-10-03 03:44:30 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:44:30 --> Controller Class Initialized
INFO - 2022-10-03 03:44:31 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_PostedSalesInvoice, BODY: {"StartDate":"2022-10-03","EndDate":"2022-10-03","PosId":""}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_PostedSalesInvoice","value":[{"@odata.etag":"W/\"JzIwOzE1MDM4NjA5MjkyOTg3MDQxNzc1MTswMDsn\"","No":"MKSSI-2201-00061","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"02:10:40","Currency_Code":"","Due_Date":"2022-10-03","Amount":1200000,"Amount_Including_VAT":1200000,"Remaining_Amount":1200000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00061","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzE5OzI1MTg2Mjg4MTkwOTg4NjM5MjAxOzAwOyc=\"","No":"MKSSI-2201-00060","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"02:10:38","Currency_Code":"","Due_Date":"2022-10-03","Amount":1200000,"Amount_Including_VAT":1200000,"Remaining_Amount":1200000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00060","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzEzOTAzMTY4MDc2MDk5NjA3MTc1MTswMDsn\"","No":"MKSSI-2201-00059","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"02:10:21","Currency_Code":"","Due_Date":"2022-10-03","Amount":640000,"Amount_Including_VAT":640000,"Remaining_Amount":0,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00059","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":true,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzE5Ozk1MjE2MjI3ODAxOTE2NzEwMjIxOzAwOyc=\"","No":"MKSSI-2201-00058","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"02:10:19","Currency_Code":"","Due_Date":"2022-10-03","Amount":2540000,"Amount_Including_VAT":2540000,"Remaining_Amount":2540000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00058","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzEyODY3NjA3OTg5NTA1MDY5NDA3MTswMDsn\"","No":"MKSSI-2201-00057","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"01:10:59","Currency_Code":"","Due_Date":"2022-10-03","Amount":1200000,"Amount_Including_VAT":1200000,"Remaining_Amount":1200000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00057","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE2ODUxNTIxMzQ2Mzc0OTgzODEzMTswMDsn\"","No":"MKSSI-2201-00056","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"01:10:57","Currency_Code":"","Due_Date":"2022-10-03","Amount":640000,"Amount_Including_VAT":640000,"Remaining_Amount":640000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00056","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE1OTQxOTIzMTMzMjI5NzA2OTAxMTswMDsn\"","No":"MKSSI-2201-00055","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"01:10:38","Currency_Code":"","Due_Date":"2022-10-03","Amount":1200000,"Amount_Including_VAT":1200000,"Remaining_Amount":1200000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00055","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE0NDcyMTI2MzA5Mzc3Mzc0MTI1MTswMDsn\"","No":"MKSSI-2201-00054","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"01:10:15","Currency_Code":"","Due_Date":"2022-10-03","Amount":1200000,"Amount_Including_VAT":1200000,"Remaining_Amount":20,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-10-03","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-10-02","External_Document_No":"MKSSI-2201-00054","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-10-02","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE4MzM4NjI1MDAwNjE3NjMxODY1MTswMDsn\"","No":"MKSSI-2201-00031","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-29","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-28","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-28","External_Document_No":"MKSSI-2201-00031","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-28","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE0OTQxOTI1NjUzMTI2NjQzODcxMTswMDsn\"","No":"MKSSI-2201-00030","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-27","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-26","External_Document_No":"MKSSI-2201-00030","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-26","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE2MTg2NjM2MDgyOTIwMjA0MTMwMTswMDsn\"","No":"MKSSI-2201-00029","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":25000,"Amount_Including_VAT":25000,"Remaining_Amount":0,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00029","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":true,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzE5OzIzMTUzOTYyMjA1MDAxNDY3NzQxOzAwOyc=\"","No":"MKSSI-2201-00028","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":1600000,"Amount_Including_VAT":1600000,"Remaining_Amount":1600000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00028","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE0NDA5MzkyNjM0MjYyNDg1MjkzMTswMDsn\"","No":"MKSSI-2201-00027","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00027","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzExODQwMzE0ODg4ODY1NDkzMDA0MTswMDsn\"","No":"MKSSI-2201-00026","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00026","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzExMTkzOTQwODUzNDAwOTkyNTc4MTswMDsn\"","No":"MKSSI-2201-00021","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00021","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzEwMzk0MDU4NTgzMjY0NjkzOTg3MTswMDsn\"","No":"MKSSI-2201-00011","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-26","Amount":400000,"Amount_Including_VAT":400000,"Remaining_Amount":400000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-26","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-25","External_Document_No":"MKSSI-2201-00011","Payment_Terms_Code":"COD","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-25","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false},{"@odata.etag":"W/\"JzIwOzE3NTE3NTY2MTMyNDkzMzUzMTk0MTswMDsn\"","No":"001","Order_No":"","ShpfyOrderNo":"","Sell_to_Customer_No":"001","Sell_to_Customer_Name":"Cibubur POS","POSTransTime":"00:00:00","Currency_Code":"","Due_Date":"2022-09-21","Amount":2250000,"Amount_Including_VAT":2250000,"Remaining_Amount":2250000,"Sell_to_Post_Code":"","Sell_to_Country_Region_Code":"","Sell_to_Contact":"","Bill_to_Customer_No":"001","Bill_to_Name":"Cibubur POS","Bill_to_Post_Code":"","Bill_to_Country_Region_Code":"","Bill_to_Contact":"","Ship_to_Code":"","Ship_to_Name":"Cibubur POS","Ship_to_Post_Code":"","Ship_to_Country_Region_Code":"","Ship_to_Contact":"","Posting_Date":"2022-09-21","Salesperson_Code":"","Shortcut_Dimension_1_Code":"","Shortcut_Dimension_2_Code":"","Location_Code":"","No_Printed":0,"Document_Date":"2022-09-21","External_Document_No":"","Payment_Terms_Code":"","Payment_Discount_Percent":0,"Shipment_Method_Code":"","Shipping_Agent_Code":"","Closed":false,"Cancelled":false,"Corrective":false,"Shipment_Date":"2022-09-21","Document_Exchange_Status":"Not Sent","_x003C_Document_Exchange_Status_x003E_":false}]}
INFO - 2022-10-03 03:44:31 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/header.php
INFO - 2022-10-03 03:44:31 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/navbar.php
INFO - 2022-10-03 03:44:31 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/footer.php
INFO - 2022-10-03 03:44:31 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\pengembalian/transaksi.php
INFO - 2022-10-03 03:44:31 --> Final output sent to browser
DEBUG - 2022-10-03 03:44:31 --> Total execution time: 1.5299
INFO - 2022-10-03 03:45:18 --> Config Class Initialized
INFO - 2022-10-03 03:45:18 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:45:18 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:45:19 --> Utf8 Class Initialized
INFO - 2022-10-03 03:45:19 --> URI Class Initialized
INFO - 2022-10-03 03:45:19 --> Router Class Initialized
INFO - 2022-10-03 03:45:19 --> Output Class Initialized
INFO - 2022-10-03 03:45:19 --> Security Class Initialized
DEBUG - 2022-10-03 03:45:19 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:45:19 --> Input Class Initialized
INFO - 2022-10-03 03:45:19 --> Language Class Initialized
INFO - 2022-10-03 03:45:19 --> Loader Class Initialized
INFO - 2022-10-03 03:45:19 --> Helper loaded: url_helper
INFO - 2022-10-03 03:45:19 --> Helper loaded: form_helper
INFO - 2022-10-03 03:45:19 --> Helper loaded: html_helper
INFO - 2022-10-03 03:45:19 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:45:19 --> Controller Class Initialized
INFO - 2022-10-03 03:45:26 --> Config Class Initialized
INFO - 2022-10-03 03:45:26 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:45:26 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:45:26 --> Utf8 Class Initialized
INFO - 2022-10-03 03:45:26 --> URI Class Initialized
DEBUG - 2022-10-03 03:45:26 --> No URI present. Default controller set.
INFO - 2022-10-03 03:45:26 --> Router Class Initialized
INFO - 2022-10-03 03:45:26 --> Output Class Initialized
INFO - 2022-10-03 03:45:26 --> Security Class Initialized
DEBUG - 2022-10-03 03:45:26 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:45:26 --> Input Class Initialized
INFO - 2022-10-03 03:45:26 --> Language Class Initialized
INFO - 2022-10-03 03:45:26 --> Loader Class Initialized
INFO - 2022-10-03 03:45:26 --> Helper loaded: url_helper
INFO - 2022-10-03 03:45:26 --> Helper loaded: form_helper
INFO - 2022-10-03 03:45:26 --> Helper loaded: html_helper
INFO - 2022-10-03 03:45:27 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:45:27 --> Controller Class Initialized
INFO - 2022-10-03 03:45:27 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/header.php
INFO - 2022-10-03 03:45:27 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/footer.php
INFO - 2022-10-03 03:45:27 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\secure/login_page.php
INFO - 2022-10-03 03:45:27 --> Final output sent to browser
DEBUG - 2022-10-03 03:45:27 --> Total execution time: 6.5164
INFO - 2022-10-03 03:45:41 --> Config Class Initialized
INFO - 2022-10-03 03:45:41 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:45:43 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:45:43 --> Utf8 Class Initialized
INFO - 2022-10-03 03:45:43 --> URI Class Initialized
INFO - 2022-10-03 03:45:43 --> Router Class Initialized
INFO - 2022-10-03 03:45:43 --> Output Class Initialized
INFO - 2022-10-03 03:45:43 --> Security Class Initialized
DEBUG - 2022-10-03 03:45:43 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:45:43 --> Input Class Initialized
INFO - 2022-10-03 03:45:43 --> Language Class Initialized
INFO - 2022-10-03 03:45:43 --> Loader Class Initialized
INFO - 2022-10-03 03:45:43 --> Helper loaded: url_helper
INFO - 2022-10-03 03:45:43 --> Helper loaded: form_helper
INFO - 2022-10-03 03:45:43 --> Helper loaded: html_helper
INFO - 2022-10-03 03:45:43 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:45:43 --> Controller Class Initialized
INFO - 2022-10-03 03:45:44 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/POS_Integration_ValidateUserPasswordLoginPOS?Company=be489792-ee2f-ed11-97e8-000d3aa1ef31, BODY: {"userName":"POS-03","userPassword":"123456"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Edm.String","value":"MKS03;No"}
INFO - 2022-10-03 03:45:44 --> Final output sent to browser
DEBUG - 2022-10-03 03:45:44 --> Total execution time: 2.9219
INFO - 2022-10-03 03:45:44 --> Config Class Initialized
INFO - 2022-10-03 03:45:44 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:45:44 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:45:44 --> Utf8 Class Initialized
INFO - 2022-10-03 03:45:44 --> URI Class Initialized
INFO - 2022-10-03 03:45:44 --> Router Class Initialized
INFO - 2022-10-03 03:45:44 --> Output Class Initialized
INFO - 2022-10-03 03:45:44 --> Security Class Initialized
DEBUG - 2022-10-03 03:45:44 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:45:44 --> Input Class Initialized
INFO - 2022-10-03 03:45:44 --> Language Class Initialized
INFO - 2022-10-03 03:45:44 --> Loader Class Initialized
INFO - 2022-10-03 03:45:44 --> Helper loaded: url_helper
INFO - 2022-10-03 03:45:44 --> Helper loaded: form_helper
INFO - 2022-10-03 03:45:44 --> Helper loaded: html_helper
INFO - 2022-10-03 03:45:44 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:45:44 --> Controller Class Initialized
INFO - 2022-10-03 03:45:47 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_GenProductPostGroup?$filter=Show_in_POS%20eq%20true, BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_GenProductPostGroup","value":[{"@odata.etag":"W/\"JzE5OzQ2Nzk0MzY5NjY1NTgwNTQzOTcxOzAwOyc=\"","Code":"BEER","Description":"Beer","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2NjMxNDQwNDUzMzg3OTUwOTUxOzAwOyc=\"","Code":"CIDER","Description":"Cider","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2MzAzODgxNjU3MzUzNjc5NzgxOzAwOyc=\"","Code":"PROMO","Description":"PROMO ITEM","Def_VAT_Prod_Posting_Group":"NOVAT","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2MTI4NjkxMzQwNjYxMDY0NzExOzAwOyc=\"","Code":"SPIRIT","Description":"SPIRIT PRODUCT","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true}]}
INFO - 2022-10-03 03:45:47 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/header.php
INFO - 2022-10-03 03:45:47 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/navbar.php
INFO - 2022-10-03 03:45:47 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/footer.php
INFO - 2022-10-03 03:45:47 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/transaksi.php
INFO - 2022-10-03 03:45:47 --> Final output sent to browser
DEBUG - 2022-10-03 03:45:47 --> Total execution time: 3.2009
INFO - 2022-10-03 03:45:54 --> Config Class Initialized
INFO - 2022-10-03 03:45:54 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:45:54 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:45:54 --> Utf8 Class Initialized
INFO - 2022-10-03 03:45:54 --> URI Class Initialized
INFO - 2022-10-03 03:45:54 --> Router Class Initialized
INFO - 2022-10-03 03:45:54 --> Output Class Initialized
INFO - 2022-10-03 03:45:54 --> Security Class Initialized
DEBUG - 2022-10-03 03:45:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:45:54 --> Input Class Initialized
INFO - 2022-10-03 03:45:54 --> Language Class Initialized
INFO - 2022-10-03 03:45:54 --> Loader Class Initialized
INFO - 2022-10-03 03:45:54 --> Helper loaded: url_helper
INFO - 2022-10-03 03:45:54 --> Helper loaded: form_helper
INFO - 2022-10-03 03:45:54 --> Helper loaded: html_helper
INFO - 2022-10-03 03:45:54 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:45:54 --> Controller Class Initialized
INFO - 2022-10-03 03:45:58 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Gen_Product_Posting_Group%20eq%20'BEER'%20and%20Location_Filter%20eq%20'MKS03', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item","value":[{"@odata.etag":"W/\"JzE5OzM5NzUzNDQ0ODk0NzA4Nzk4NDgxOzAwOyc=\"","No":"BBIN-001","Description":"BINTANG BREMER CRT 16 BTL 620 ML","Inventory":0,"Sales_Price":0,"Sales_Discount":0,"Vat":"VAT11","Gen_Product_Posting_Group":"BEER","Global_Dimension_1_Filter":"","Global_Dimension_2_Filter":"","Location_Filter":"MKS03","Drop_Shipment_Filter":"","Variant_Filter":"","Lot_No_Filter":"","Serial_No_Filter":"","Unit_of_Measure_Filter":"","Package_No_Filter":""},{"@odata.etag":"W/\"JzE5Ozg3MDg1NjMwMTEyODc1NjU1MzUxOzAwOyc=\"","No":"BIRA-2203-001","Description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","Inventory":83,"Sales_Price":400000,"Sales_Discount":0,"Vat":"VAT11","Gen_Product_Posting_Group":"BEER","Global_Dimension_1_Filter":"","Global_Dimension_2_Filter":"","Location_Filter":"MKS03","Drop_Shipment_Filter":"","Variant_Filter":"","Lot_No_Filter":"","Serial_No_Filter":"","Unit_of_Measure_Filter":"","Package_No_Filter":""}]}
INFO - 2022-10-03 03:45:58 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:45:58 --> Final output sent to browser
DEBUG - 2022-10-03 03:45:58 --> Total execution time: 3.5736
INFO - 2022-10-03 03:46:03 --> Config Class Initialized
INFO - 2022-10-03 03:46:03 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:46:03 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:46:03 --> Utf8 Class Initialized
INFO - 2022-10-03 03:46:03 --> URI Class Initialized
INFO - 2022-10-03 03:46:03 --> Router Class Initialized
INFO - 2022-10-03 03:46:03 --> Output Class Initialized
INFO - 2022-10-03 03:46:03 --> Security Class Initialized
DEBUG - 2022-10-03 03:46:03 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:46:03 --> Input Class Initialized
INFO - 2022-10-03 03:46:03 --> Language Class Initialized
INFO - 2022-10-03 03:46:03 --> Loader Class Initialized
INFO - 2022-10-03 03:46:03 --> Helper loaded: url_helper
INFO - 2022-10-03 03:46:03 --> Helper loaded: form_helper
INFO - 2022-10-03 03:46:03 --> Helper loaded: html_helper
INFO - 2022-10-03 03:46:03 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:46:03 --> Controller Class Initialized
INFO - 2022-10-03 03:46:04 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Gen_Product_Posting_Group%20eq%20'CIDER'%20and%20Location_Filter%20eq%20'MKS03', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item","value":[{"@odata.etag":"W/\"JzE5OzM5OTIxMjIxMzIyMTkzNzk0MDYxOzAwOyc=\"","No":"SLQB-2208-006","Description":"DE KUPYER GRAPEFRUIT/JERUK BALI ASAM MERAH 700 ML","Inventory":196,"Sales_Price":25000,"Sales_Discount":0,"Vat":"VAT11","Gen_Product_Posting_Group":"CIDER","Global_Dimension_1_Filter":"","Global_Dimension_2_Filter":"","Location_Filter":"MKS03","Drop_Shipment_Filter":"","Variant_Filter":"","Lot_No_Filter":"","Serial_No_Filter":"","Unit_of_Measure_Filter":"","Package_No_Filter":""}]}
INFO - 2022-10-03 03:46:04 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:46:04 --> Final output sent to browser
DEBUG - 2022-10-03 03:46:04 --> Total execution time: 1.7802
INFO - 2022-10-03 03:46:13 --> Config Class Initialized
INFO - 2022-10-03 03:46:13 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:46:13 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:46:13 --> Utf8 Class Initialized
INFO - 2022-10-03 03:46:13 --> URI Class Initialized
INFO - 2022-10-03 03:46:13 --> Router Class Initialized
INFO - 2022-10-03 03:46:13 --> Output Class Initialized
INFO - 2022-10-03 03:46:13 --> Security Class Initialized
DEBUG - 2022-10-03 03:46:13 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:46:13 --> Input Class Initialized
INFO - 2022-10-03 03:46:13 --> Language Class Initialized
INFO - 2022-10-03 03:46:13 --> Loader Class Initialized
INFO - 2022-10-03 03:46:13 --> Helper loaded: url_helper
INFO - 2022-10-03 03:46:13 --> Helper loaded: form_helper
INFO - 2022-10-03 03:46:13 --> Helper loaded: html_helper
INFO - 2022-10-03 03:46:13 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:46:13 --> Controller Class Initialized
INFO - 2022-10-03 03:46:14 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Gen_Product_Posting_Group%20eq%20'SPIRIT'%20and%20Location_Filter%20eq%20'MKS03', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item","value":[]}
INFO - 2022-10-03 03:46:14 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:46:14 --> Final output sent to browser
DEBUG - 2022-10-03 03:46:14 --> Total execution time: 5.4305
INFO - 2022-10-03 03:46:17 --> Config Class Initialized
INFO - 2022-10-03 03:46:17 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:46:17 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:46:17 --> Utf8 Class Initialized
INFO - 2022-10-03 03:46:17 --> URI Class Initialized
INFO - 2022-10-03 03:46:17 --> Router Class Initialized
INFO - 2022-10-03 03:46:17 --> Output Class Initialized
INFO - 2022-10-03 03:46:17 --> Security Class Initialized
DEBUG - 2022-10-03 03:46:17 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:46:17 --> Input Class Initialized
INFO - 2022-10-03 03:46:17 --> Language Class Initialized
INFO - 2022-10-03 03:46:17 --> Loader Class Initialized
INFO - 2022-10-03 03:46:17 --> Helper loaded: url_helper
INFO - 2022-10-03 03:46:17 --> Helper loaded: form_helper
INFO - 2022-10-03 03:46:17 --> Helper loaded: html_helper
INFO - 2022-10-03 03:46:17 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:46:17 --> Controller Class Initialized
INFO - 2022-10-03 03:46:18 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('MKS%20DEMO')/POS_Promotions, BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('MKS%20DEMO')/POS_Promotions","value":[{"@odata.etag":"W/\"JzIwOzE0ODc2ODM0NzkxMzU5ODc2ODY4MTswMDsn\"","Promo_Code":"A01","Description":"Estrela dan Cider 20%","Location_Code":"MKS03","Amount":320000,"Starting_Date":"2022-09-01","Ending_Date":"2022-12-31"},{"@odata.etag":"W/\"JzIwOzE0OTIwMjM5NDcyNDY0ODQyOTU0MTswMDsn\"","Promo_Code":"A02","Description":"Promo 1 botol Estrella","Location_Code":"MKS03","Amount":1200000,"Starting_Date":"2022-09-01","Ending_Date":"2022-12-31"}]}
ERROR - 2022-10-03 03:46:18 --> Severity: Warning --> Creating default object from empty value C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\controllers\Penjualan.php 150
INFO - 2022-10-03 03:46:18 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:46:18 --> Final output sent to browser
DEBUG - 2022-10-03 03:46:18 --> Total execution time: 1.5511
INFO - 2022-10-03 03:46:22 --> Config Class Initialized
INFO - 2022-10-03 03:46:22 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:46:23 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:46:23 --> Utf8 Class Initialized
INFO - 2022-10-03 03:46:23 --> URI Class Initialized
INFO - 2022-10-03 03:46:23 --> Router Class Initialized
INFO - 2022-10-03 03:46:23 --> Output Class Initialized
INFO - 2022-10-03 03:46:23 --> Security Class Initialized
DEBUG - 2022-10-03 03:46:23 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:46:23 --> Input Class Initialized
INFO - 2022-10-03 03:46:23 --> Language Class Initialized
INFO - 2022-10-03 03:46:23 --> Loader Class Initialized
INFO - 2022-10-03 03:46:23 --> Helper loaded: url_helper
INFO - 2022-10-03 03:46:23 --> Helper loaded: form_helper
INFO - 2022-10-03 03:46:23 --> Helper loaded: html_helper
INFO - 2022-10-03 03:46:23 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:46:23 --> Controller Class Initialized
INFO - 2022-10-03 03:46:24 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('MKS%20DEMO')/POS_PromotionsSubform?$filter=Promo_Code%20eq%20'A02', BODY: {"Code":"A02","LocationCode":"MKS03"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('MKS%20DEMO')/POS_PromotionsSubform","value":[{"@odata.etag":"W/\"JzE5OzU4NTA3NTI0Nzc0NDI1NzY5OTQxOzAwOyc=\"","Promo_Code":"A02","Line_No":10000,"Item_No":"BIRA-2203-001","Description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","Quantity":1,"Sales_Price":1500000,"Discount_Amount":300000,"Discount_Percentage":0,"VAT_Prod":"NOVAT"}]}
INFO - 2022-10-03 03:46:24 --> Final output sent to browser
DEBUG - 2022-10-03 03:46:24 --> Total execution time: 2.3919
INFO - 2022-10-03 03:46:43 --> Config Class Initialized
INFO - 2022-10-03 03:46:43 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:46:43 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:46:43 --> Utf8 Class Initialized
INFO - 2022-10-03 03:46:43 --> URI Class Initialized
INFO - 2022-10-03 03:46:43 --> Router Class Initialized
INFO - 2022-10-03 03:46:43 --> Output Class Initialized
INFO - 2022-10-03 03:46:43 --> Security Class Initialized
DEBUG - 2022-10-03 03:46:43 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:46:43 --> Input Class Initialized
INFO - 2022-10-03 03:46:43 --> Language Class Initialized
INFO - 2022-10-03 03:46:43 --> Loader Class Initialized
INFO - 2022-10-03 03:46:43 --> Helper loaded: url_helper
INFO - 2022-10-03 03:46:43 --> Helper loaded: form_helper
INFO - 2022-10-03 03:46:43 --> Helper loaded: html_helper
INFO - 2022-10-03 03:46:43 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:46:43 --> Controller Class Initialized
INFO - 2022-10-03 03:46:44 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('MKS%20DEMO')/POS_PromotionsSubform?$filter=Promo_Code%20eq%20'A01', BODY: {"Code":"A01","LocationCode":"MKS03"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('MKS%20DEMO')/POS_PromotionsSubform","value":[{"@odata.etag":"W/\"JzE5OzU4NTA0NjI5ODAyOTUwNTQ5NzgxOzAwOyc=\"","Promo_Code":"A01","Line_No":10000,"Item_No":"BIRA-2203-001","Description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","Quantity":1,"Sales_Price":800000,"Discount_Amount":480000,"Discount_Percentage":0.6,"VAT_Prod":"NOVAT"},{"@odata.etag":"W/\"JzIwOzE2MjA2MDQxODA3Mzg0MjE3NDQ2MTswMDsn\"","Promo_Code":"A01","Line_No":20000,"Item_No":"SLQB-2208-006","Description":"DE KUPYER GRAPEFRUIT/JERUK BALI ASAM MERAH 700 ML","Quantity":2,"Sales_Price":900000,"Discount_Amount":1480000,"Discount_Percentage":1.64444444444444444,"VAT_Prod":"NOVAT"}]}
INFO - 2022-10-03 03:46:44 --> Final output sent to browser
DEBUG - 2022-10-03 03:46:44 --> Total execution time: 1.3987
INFO - 2022-10-03 03:47:04 --> Config Class Initialized
INFO - 2022-10-03 03:47:04 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:47:04 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:47:04 --> Utf8 Class Initialized
INFO - 2022-10-03 03:47:04 --> URI Class Initialized
INFO - 2022-10-03 03:47:04 --> Router Class Initialized
INFO - 2022-10-03 03:47:04 --> Output Class Initialized
INFO - 2022-10-03 03:47:04 --> Security Class Initialized
DEBUG - 2022-10-03 03:47:04 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:47:04 --> Input Class Initialized
INFO - 2022-10-03 03:47:05 --> Language Class Initialized
INFO - 2022-10-03 03:47:05 --> Loader Class Initialized
INFO - 2022-10-03 03:47:05 --> Helper loaded: url_helper
INFO - 2022-10-03 03:47:05 --> Helper loaded: form_helper
INFO - 2022-10-03 03:47:05 --> Helper loaded: html_helper
INFO - 2022-10-03 03:47:05 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:47:05 --> Controller Class Initialized
INFO - 2022-10-03 03:47:06 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_GenProductPostGroup?$filter=Show_in_POS%20eq%20true, BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_GenProductPostGroup","value":[{"@odata.etag":"W/\"JzE5OzQ2Nzk0MzY5NjY1NTgwNTQzOTcxOzAwOyc=\"","Code":"BEER","Description":"Beer","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2NjMxNDQwNDUzMzg3OTUwOTUxOzAwOyc=\"","Code":"CIDER","Description":"Cider","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2MzAzODgxNjU3MzUzNjc5NzgxOzAwOyc=\"","Code":"PROMO","Description":"PROMO ITEM","Def_VAT_Prod_Posting_Group":"NOVAT","Auto_Insert_Default":true,"Show_in_POS":true},{"@odata.etag":"W/\"JzE5OzQ2MTI4NjkxMzQwNjYxMDY0NzExOzAwOyc=\"","Code":"SPIRIT","Description":"SPIRIT PRODUCT","Def_VAT_Prod_Posting_Group":"VAT11","Auto_Insert_Default":true,"Show_in_POS":true}]}
INFO - 2022-10-03 03:47:06 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/header.php
INFO - 2022-10-03 03:47:06 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/navbar.php
INFO - 2022-10-03 03:47:06 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\include/footer.php
INFO - 2022-10-03 03:47:06 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/transaksi.php
INFO - 2022-10-03 03:47:06 --> Final output sent to browser
DEBUG - 2022-10-03 03:47:06 --> Total execution time: 1.8096
INFO - 2022-10-03 03:47:09 --> Config Class Initialized
INFO - 2022-10-03 03:47:09 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:47:09 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:47:09 --> Utf8 Class Initialized
INFO - 2022-10-03 03:47:09 --> URI Class Initialized
INFO - 2022-10-03 03:47:09 --> Router Class Initialized
INFO - 2022-10-03 03:47:09 --> Output Class Initialized
INFO - 2022-10-03 03:47:09 --> Security Class Initialized
DEBUG - 2022-10-03 03:47:09 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:47:09 --> Input Class Initialized
INFO - 2022-10-03 03:47:09 --> Language Class Initialized
INFO - 2022-10-03 03:47:09 --> Loader Class Initialized
INFO - 2022-10-03 03:47:09 --> Helper loaded: url_helper
INFO - 2022-10-03 03:47:09 --> Helper loaded: form_helper
INFO - 2022-10-03 03:47:09 --> Helper loaded: html_helper
INFO - 2022-10-03 03:47:09 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:47:09 --> Controller Class Initialized
INFO - 2022-10-03 03:47:10 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('MKS%20DEMO')/POS_Promotions, BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('MKS%20DEMO')/POS_Promotions","value":[{"@odata.etag":"W/\"JzIwOzE0ODc2ODM0NzkxMzU5ODc2ODY4MTswMDsn\"","Promo_Code":"A01","Description":"Estrela dan Cider 20%","Location_Code":"MKS03","Amount":320000,"Starting_Date":"2022-09-01","Ending_Date":"2022-12-31"},{"@odata.etag":"W/\"JzIwOzE0OTIwMjM5NDcyNDY0ODQyOTU0MTswMDsn\"","Promo_Code":"A02","Description":"Promo 1 botol Estrella","Location_Code":"MKS03","Amount":1200000,"Starting_Date":"2022-09-01","Ending_Date":"2022-12-31"}]}
ERROR - 2022-10-03 03:47:10 --> Severity: Warning --> Creating default object from empty value C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\controllers\Penjualan.php 150
INFO - 2022-10-03 03:47:10 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:47:10 --> Final output sent to browser
DEBUG - 2022-10-03 03:47:10 --> Total execution time: 1.0293
INFO - 2022-10-03 03:47:11 --> Config Class Initialized
INFO - 2022-10-03 03:47:11 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:47:11 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:47:11 --> Utf8 Class Initialized
INFO - 2022-10-03 03:47:11 --> URI Class Initialized
INFO - 2022-10-03 03:47:11 --> Router Class Initialized
INFO - 2022-10-03 03:47:11 --> Output Class Initialized
INFO - 2022-10-03 03:47:11 --> Security Class Initialized
DEBUG - 2022-10-03 03:47:11 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:47:11 --> Input Class Initialized
INFO - 2022-10-03 03:47:11 --> Language Class Initialized
INFO - 2022-10-03 03:47:12 --> Loader Class Initialized
INFO - 2022-10-03 03:47:12 --> Helper loaded: url_helper
INFO - 2022-10-03 03:47:12 --> Helper loaded: form_helper
INFO - 2022-10-03 03:47:12 --> Helper loaded: html_helper
INFO - 2022-10-03 03:47:12 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:47:12 --> Controller Class Initialized
INFO - 2022-10-03 03:47:13 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('MKS%20DEMO')/POS_PromotionsSubform?$filter=Promo_Code%20eq%20'A01', BODY: {"Code":"A01","LocationCode":"MKS03"}, RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('MKS%20DEMO')/POS_PromotionsSubform","value":[{"@odata.etag":"W/\"JzE5OzU4NTA0NjI5ODAyOTUwNTQ5NzgxOzAwOyc=\"","Promo_Code":"A01","Line_No":10000,"Item_No":"BIRA-2203-001","Description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","Quantity":1,"Sales_Price":800000,"Discount_Amount":480000,"Discount_Percentage":0.6,"VAT_Prod":"NOVAT"},{"@odata.etag":"W/\"JzIwOzE2MjA2MDQxODA3Mzg0MjE3NDQ2MTswMDsn\"","Promo_Code":"A01","Line_No":20000,"Item_No":"SLQB-2208-006","Description":"DE KUPYER GRAPEFRUIT/JERUK BALI ASAM MERAH 700 ML","Quantity":2,"Sales_Price":900000,"Discount_Amount":1480000,"Discount_Percentage":1.64444444444444444,"VAT_Prod":"NOVAT"}]}
INFO - 2022-10-03 03:47:13 --> Final output sent to browser
DEBUG - 2022-10-03 03:47:13 --> Total execution time: 2.0194
INFO - 2022-10-03 03:47:17 --> Config Class Initialized
INFO - 2022-10-03 03:47:17 --> Hooks Class Initialized
DEBUG - 2022-10-03 03:47:17 --> UTF-8 Support Enabled
INFO - 2022-10-03 03:47:17 --> Utf8 Class Initialized
INFO - 2022-10-03 03:47:17 --> URI Class Initialized
INFO - 2022-10-03 03:47:17 --> Router Class Initialized
INFO - 2022-10-03 03:47:17 --> Output Class Initialized
INFO - 2022-10-03 03:47:17 --> Security Class Initialized
DEBUG - 2022-10-03 03:47:17 --> Global POST, GET and COOKIE data sanitized
INFO - 2022-10-03 03:47:17 --> Input Class Initialized
INFO - 2022-10-03 03:47:17 --> Language Class Initialized
INFO - 2022-10-03 03:47:17 --> Loader Class Initialized
INFO - 2022-10-03 03:47:17 --> Helper loaded: url_helper
INFO - 2022-10-03 03:47:17 --> Helper loaded: form_helper
INFO - 2022-10-03 03:47:17 --> Helper loaded: html_helper
INFO - 2022-10-03 03:47:17 --> Session: Class initialized using 'files' driver.
INFO - 2022-10-03 03:47:17 --> Controller Class Initialized
INFO - 2022-10-03 03:47:18 --> URL: https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item?$filter=Gen_Product_Posting_Group%20eq%20'BEER'%20and%20Location_Filter%20eq%20'MKS03', BODY: [], RESPONSE: {"@odata.context":"https://api.businesscentral.dynamics.com/v2.0/8a0e3ae1-437d-4b41-a199-69cbaca7641a/SandboxPOC/ODataV4/$metadata#Company('be489792-ee2f-ed11-97e8-000d3aa1ef31')/POS_Item","value":[{"@odata.etag":"W/\"JzE5OzM5NzUzNDQ0ODk0NzA4Nzk4NDgxOzAwOyc=\"","No":"BBIN-001","Description":"BINTANG BREMER CRT 16 BTL 620 ML","Inventory":0,"Sales_Price":0,"Sales_Discount":0,"Vat":"VAT11","Gen_Product_Posting_Group":"BEER","Global_Dimension_1_Filter":"","Global_Dimension_2_Filter":"","Location_Filter":"MKS03","Drop_Shipment_Filter":"","Variant_Filter":"","Lot_No_Filter":"","Serial_No_Filter":"","Unit_of_Measure_Filter":"","Package_No_Filter":""},{"@odata.etag":"W/\"JzE5Ozg3MDg1NjMwMTEyODc1NjU1MzUxOzAwOyc=\"","No":"BIRA-2203-001","Description":"ESTRELLA DAMM BEER - BOTTLE 330 ML","Inventory":83,"Sales_Price":400000,"Sales_Discount":0,"Vat":"VAT11","Gen_Product_Posting_Group":"BEER","Global_Dimension_1_Filter":"","Global_Dimension_2_Filter":"","Location_Filter":"MKS03","Drop_Shipment_Filter":"","Variant_Filter":"","Lot_No_Filter":"","Serial_No_Filter":"","Unit_of_Measure_Filter":"","Package_No_Filter":""}]}
INFO - 2022-10-03 03:47:18 --> File loaded: C:\Users\Arg\Downloads\MPG\MPG\ke folder XAMPP httdoc\vines_pos\application\views\penjualan/load_transaksi.php
INFO - 2022-10-03 03:47:18 --> Final output sent to browser
DEBUG - 2022-10-03 03:47:18 --> Total execution time: 1.3606

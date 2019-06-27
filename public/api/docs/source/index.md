---
title: API Reference

language_tabs:
- bash
- javascript
- php

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/api/docs/collection.json)

<!-- END_INFO -->

#Reception

## APIs for managing receptions

This group of APIs,help you register receptions and 
search by status, patient national id or recepted date.

<aside class="notice"> 
  Access: @role admin OR @permission can-manage-radiology,can-register-reception
</aside>
<aside class="notice"> 
  Filterable: status,national_id
</aside>
<!-- START_0c0387efd735bd5f9cee23084ef4e53e -->
## api/receptions
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions" 
```
```javascript
const url = new URL("/api/receptions");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions`


<!-- END_0c0387efd735bd5f9cee23084ef4e53e -->

<!-- START_2cd93dad74d5d1c4cce15f4ebef1e5e3 -->
## Store a newly created resource in storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "/api/receptions" \
    -H "Content-Type: application/json" \
    -d '{"national_id":5,"reception_date":"voluptas"}'

```
```javascript
const url = new URL("/api/receptions");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "national_id": 5,
    "reception_date": "voluptas"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/receptions", [
    'headers' => [
            "Content-Type" => "application/json",
        ],
    'json' => [
            "national_id" => "5",
            "reception_date" => "voluptas",
        ],
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "message": "update successfuly",
    "code": 200
}
```

### HTTP Request
`POST api/receptions`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    national_id | integer |  required  | National id of patients
    reception_date | date |  required  | Reception register

<!-- END_2cd93dad74d5d1c4cce15f4ebef1e5e3 -->

<!-- START_6a9feb85dd1bde13006f57ef5e3fc4fb -->
## api/receptions/{reception}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions/1" 
```
```javascript
const url = new URL("/api/receptions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/{reception}`


<!-- END_6a9feb85dd1bde13006f57ef5e3fc4fb -->

<!-- START_fd3706d3f8fe0a5d5a7c122704ac55c6 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/receptions/1" 
```
```javascript
const url = new URL("/api/receptions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/receptions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/receptions/{reception}`

`PATCH api/receptions/{reception}`


<!-- END_fd3706d3f8fe0a5d5a7c122704ac55c6 -->

<!-- START_37aa381c605935d5a45c506ff3c23ae5 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/receptions/1" 
```
```javascript
const url = new URL("/api/receptions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/receptions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/receptions/{reception}`


<!-- END_37aa381c605935d5a45c506ff3c23ae5 -->

#Users Me

APIs for managing athenticated users
<!-- START_9283036de635fde6b85e3b7f2eeddee1 -->
## Return user all and new notifications count

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/users/me/notify" 
```
```javascript
const url = new URL("/api/users/me/notify");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/me/notify", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "all": 100,
    "new": 4
}
```

### HTTP Request
`GET api/users/me/notify`


<!-- END_9283036de635fde6b85e3b7f2eeddee1 -->

<!-- START_c872096b9d292271482ff1a24fd89ff2 -->
## Return specific user notification data

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/users/me/notify/1" 
```
```javascript
const url = new URL("/api/users/me/notify/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/me/notify/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "type": "App\\Notifications\\UserLogedIn",
    "data": "User loged in at 19:45",
    "created_at": "2019-11-12 19:45"
}
```
> Example response (404):

```json
{
    "message": "Resource not found"
}
```

### HTTP Request
`GET api/users/me/notify/{notify}`


<!-- END_c872096b9d292271482ff1a24fd89ff2 -->

#general
<!-- START_774744abc65e28e4368f69ef4798a8f7 -->
## api/doctors
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/doctors" 
```
```javascript
const url = new URL("/api/doctors");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/doctors", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctors`


<!-- END_774744abc65e28e4368f69ef4798a8f7 -->

<!-- START_d2e6f599a5874844f4a0830deeeaef34 -->
## api/doctors/{doctor}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/doctors/1" 
```
```javascript
const url = new URL("/api/doctors/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/doctors/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/doctors/{doctor}`


<!-- END_d2e6f599a5874844f4a0830deeeaef34 -->

<!-- START_cdf5e02e9b913556f9304546d59e6c56 -->
## api/patients
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/patients" 
```
```javascript
const url = new URL("/api/patients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/patients", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patients`


<!-- END_cdf5e02e9b913556f9304546d59e6c56 -->

<!-- START_e21961238df73c8544f00766ed069000 -->
## api/patients/{patient}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/patients/1" 
```
```javascript
const url = new URL("/api/patients/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/patients/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/patients/{patient}`


<!-- END_e21961238df73c8544f00766ed069000 -->

<!-- START_f2c1d0906ccfd7d596316f0dc6175082 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/specialities" 
```
```javascript
const url = new URL("/api/specialities");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/specialities", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/specialities`


<!-- END_f2c1d0906ccfd7d596316f0dc6175082 -->

<!-- START_da1a4c0f7c1e76468960296549dd1003 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/specialities/1" 
```
```javascript
const url = new URL("/api/specialities/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/specialities/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/specialities/{id}`


<!-- END_da1a4c0f7c1e76468960296549dd1003 -->

<!-- START_4738f777cbefabcb4080bdad81ad48b2 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/specialities" 
```
```javascript
const url = new URL("/api/specialities");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/specialities", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/specialities`


<!-- END_4738f777cbefabcb4080bdad81ad48b2 -->

<!-- START_e4dc4667306172899792bdf944d41026 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/specialities/1" 
```
```javascript
const url = new URL("/api/specialities/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/specialities/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/specialities/{id}`


<!-- END_e4dc4667306172899792bdf944d41026 -->

<!-- START_ae10e4855d4e4ed75e1b1ad9de01e319 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/specialities/1" 
```
```javascript
const url = new URL("/api/specialities/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/specialities/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/specialities/{id}`


<!-- END_ae10e4855d4e4ed75e1b1ad9de01e319 -->

<!-- START_03155bf6fa71dfd4bafd67c72264c210 -->
## api/radiotypes
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/radiotypes" 
```
```javascript
const url = new URL("/api/radiotypes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/radiotypes", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/radiotypes`


<!-- END_03155bf6fa71dfd4bafd67c72264c210 -->

<!-- START_f5bce077d0521fd9b3cd4f38b8813a6a -->
## api/radiotypes/{id}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/radiotypes/1" 
```
```javascript
const url = new URL("/api/radiotypes/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/radiotypes/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/radiotypes/{id}`


<!-- END_f5bce077d0521fd9b3cd4f38b8813a6a -->

<!-- START_c5eb88b77a47a4bdaef676c31ad0213f -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/radiotypes" 
```
```javascript
const url = new URL("/api/radiotypes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/radiotypes", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/radiotypes`


<!-- END_c5eb88b77a47a4bdaef676c31ad0213f -->

<!-- START_eb9703073973d8d146b06c1293fb884d -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/radiotypes/1" 
```
```javascript
const url = new URL("/api/radiotypes/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/radiotypes/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/radiotypes/{id}`


<!-- END_eb9703073973d8d146b06c1293fb884d -->

<!-- START_172cacd2e40f3fcfc9a21846fc93c0b0 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/radiotypes/1" 
```
```javascript
const url = new URL("/api/radiotypes/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/radiotypes/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/radiotypes/{id}`


<!-- END_172cacd2e40f3fcfc9a21846fc93c0b0 -->

<!-- START_28393d33008b0fcc531ea6be6dc69a81 -->
## api/receptions/statistics
> Example request:

```bash
curl -X GET -G "/api/receptions/statistics" 
```
```javascript
const url = new URL("/api/receptions/statistics");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/statistics", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/statistics`


<!-- END_28393d33008b0fcc531ea6be6dc69a81 -->

<!-- START_80a0a35ab69e1c9ec9c0ced5add5e2d2 -->
## api/receptions/capture
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions/capture" 
```
```javascript
const url = new URL("/api/receptions/capture");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/capture", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/capture`


<!-- END_80a0a35ab69e1c9ec9c0ced5add5e2d2 -->

<!-- START_68bd5d918a09052bb99bc14552ca1457 -->
## api/receptions/{reception}/capture
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions/1/capture" 
```
```javascript
const url = new URL("/api/receptions/1/capture");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/1/capture", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/{reception}/capture`


<!-- END_68bd5d918a09052bb99bc14552ca1457 -->

<!-- START_9cd93116219b5f3182b659431c42d758 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/receptions/1/capture" 
```
```javascript
const url = new URL("/api/receptions/1/capture");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/receptions/1/capture", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/receptions/{reception}/capture`


<!-- END_9cd93116219b5f3182b659431c42d758 -->

<!-- START_563770685297f10a16e0ac975d2521e8 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/receptions/1/capture" 
```
```javascript
const url = new URL("/api/receptions/1/capture");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/receptions/1/capture", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/receptions/{reception}/capture`


<!-- END_563770685297f10a16e0ac975d2521e8 -->

<!-- START_39cf96b6d46852846b45a98db0108b4a -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X GET -G "/api/receptions/1/capture/1" 
```
```javascript
const url = new URL("/api/receptions/1/capture/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/1/capture/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/{reception}/capture/{capture}`


<!-- END_39cf96b6d46852846b45a98db0108b4a -->

<!-- START_40472692884947df201eda32fb0311cc -->
## api/receptions/result
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions/result" 
```
```javascript
const url = new URL("/api/receptions/result");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/result", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/result`


<!-- END_40472692884947df201eda32fb0311cc -->

<!-- START_7da6a59f90c8f2f1d5651607e1d7680e -->
## api/receptions/{reception}/result
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/receptions/1/result" 
```
```javascript
const url = new URL("/api/receptions/1/result");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/1/result", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/{reception}/result`


<!-- END_7da6a59f90c8f2f1d5651607e1d7680e -->

<!-- START_94b6faf634e9270dbe1baca468d18ba8 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/receptions/1/result" 
```
```javascript
const url = new URL("/api/receptions/1/result");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/receptions/1/result", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/receptions/{reception}/result`


<!-- END_94b6faf634e9270dbe1baca468d18ba8 -->

<!-- START_aa1d428276d8e989106b2b508f07e617 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/receptions/1/result" 
```
```javascript
const url = new URL("/api/receptions/1/result");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/receptions/1/result", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/receptions/{reception}/result`


<!-- END_aa1d428276d8e989106b2b508f07e617 -->

<!-- START_cbce2782386d3ae75a4995212a5c6b74 -->
## Reject the specified reception.

> Example request:

```bash
curl -X PATCH "/api/receptions/1/result" 
```
```javascript
const url = new URL("/api/receptions/1/result");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->patch("/api/receptions/1/result", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PATCH api/receptions/{reception}/result`


<!-- END_cbce2782386d3ae75a4995212a5c6b74 -->

<!-- START_bc400bcfcd5e5fa059f3d550f4cf3917 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X GET -G "/api/receptions/1/votes" 
```
```javascript
const url = new URL("/api/receptions/1/votes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/receptions/1/votes", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/receptions/{reception}/votes`


<!-- END_bc400bcfcd5e5fa059f3d550f4cf3917 -->

<!-- START_8299cfe632b8cd48e58e69e27a18f1ed -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/receptions/1/votes" 
```
```javascript
const url = new URL("/api/receptions/1/votes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/receptions/1/votes", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/receptions/{reception}/votes`


<!-- END_8299cfe632b8cd48e58e69e27a18f1ed -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login user and create token

> Example request:

```bash
curl -X POST "/api/auth/login" 
```
```javascript
const url = new URL("/api/auth/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/auth/login", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
## Logout user (Revoke the token)

> Example request:

```bash
curl -X GET -G "/api/auth/logout" 
```
```javascript
const url = new URL("/api/auth/logout");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/auth/logout", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/logout`


<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->

<!-- START_65b6b5b61b3513f228f76bab268ff3be -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/auth/roles" 
```
```javascript
const url = new URL("/api/auth/roles");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/auth/roles", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/roles`


<!-- END_65b6b5b61b3513f228f76bab268ff3be -->

<!-- START_dbb9179c4af037ea76bd0c429f589edd -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/auth/roles" 
```
```javascript
const url = new URL("/api/auth/roles");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/auth/roles", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/auth/roles`


<!-- END_dbb9179c4af037ea76bd0c429f589edd -->

<!-- START_4931fcd66424812094d9f0be9488a1e5 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/auth/roles/1" 
```
```javascript
const url = new URL("/api/auth/roles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/auth/roles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/roles/{role}`


<!-- END_4931fcd66424812094d9f0be9488a1e5 -->

<!-- START_102d9f02e97e5f5d2eb2c2e80cf6410b -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/auth/roles/1" 
```
```javascript
const url = new URL("/api/auth/roles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/auth/roles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/auth/roles/{role}`

`PATCH api/auth/roles/{role}`


<!-- END_102d9f02e97e5f5d2eb2c2e80cf6410b -->

<!-- START_bdbf4418356bd518ffe12ef7dd4f8ad6 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/auth/roles/1" 
```
```javascript
const url = new URL("/api/auth/roles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/auth/roles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/auth/roles/{role}`


<!-- END_bdbf4418356bd518ffe12ef7dd4f8ad6 -->

<!-- START_5eb9ecff46107cf2f0064b7b06b96cbc -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/auth/permissions" 
```
```javascript
const url = new URL("/api/auth/permissions");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/auth/permissions", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/permissions`


<!-- END_5eb9ecff46107cf2f0064b7b06b96cbc -->

<!-- START_821850b3722cf0177c0a216e1e475151 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/auth/permissions" 
```
```javascript
const url = new URL("/api/auth/permissions");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/auth/permissions", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/auth/permissions`


<!-- END_821850b3722cf0177c0a216e1e475151 -->

<!-- START_a0a3e5d305e4b98e681ebe18b6dd45ec -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/auth/permissions/1" 
```
```javascript
const url = new URL("/api/auth/permissions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/auth/permissions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/auth/permissions/{permission}`


<!-- END_a0a3e5d305e4b98e681ebe18b6dd45ec -->

<!-- START_c4ea5ba56f13d5cdc578b5f004326220 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/auth/permissions/1" 
```
```javascript
const url = new URL("/api/auth/permissions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/auth/permissions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/auth/permissions/{permission}`

`PATCH api/auth/permissions/{permission}`


<!-- END_c4ea5ba56f13d5cdc578b5f004326220 -->

<!-- START_227850c3513ff4e1aab8c00a6602af53 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/auth/permissions/1" 
```
```javascript
const url = new URL("/api/auth/permissions/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/auth/permissions/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/auth/permissions/{permission}`


<!-- END_227850c3513ff4e1aab8c00a6602af53 -->

<!-- START_e375ff0452feb130adcd66e7504890ce -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/users/me/password" 
```
```javascript
const url = new URL("/api/users/me/password");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/users/me/password", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/users/me/password`


<!-- END_e375ff0452feb130adcd66e7504890ce -->

<!-- START_14519a4ae9ec904ac3cef59a881efa53 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/users/me/avatar" 
```
```javascript
const url = new URL("/api/users/me/avatar");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/me/avatar", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users/me/avatar`


<!-- END_14519a4ae9ec904ac3cef59a881efa53 -->

<!-- START_22cac4e428316b498ee7155193eda3b4 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/users/me/avatar" 
```
```javascript
const url = new URL("/api/users/me/avatar");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/users/me/avatar", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/users/me/avatar`


<!-- END_22cac4e428316b498ee7155193eda3b4 -->

<!-- START_8d1e53fcf4d2d02a6144ed392de856bf -->
## Retrieve profile of the current user

> Example request:

```bash
curl -X GET -G "/api/users/me" 
```
```javascript
const url = new URL("/api/users/me");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/me", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users/me`


<!-- END_8d1e53fcf4d2d02a6144ed392de856bf -->

<!-- START_973a5ca8eb9c7f03bf3c48555b49ba3c -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/users/me" 
```
```javascript
const url = new URL("/api/users/me");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/users/me", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/users/me`


<!-- END_973a5ca8eb9c7f03bf3c48555b49ba3c -->

<!-- START_a58cf0572b42607d0d7f19ea0b5dac56 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/users/batch/active/1" 
```
```javascript
const url = new URL("/api/users/batch/active/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/batch/active/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users/batch/active/{active}`


<!-- END_a58cf0572b42607d0d7f19ea0b5dac56 -->

<!-- START_5e2567d1c0c43d42e97d870f63dc7fa9 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/users/batch/active/1" 
```
```javascript
const url = new URL("/api/users/batch/active/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/users/batch/active/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/users/batch/active/{active}`

`PATCH api/users/batch/active/{active}`


<!-- END_5e2567d1c0c43d42e97d870f63dc7fa9 -->

<!-- START_9de992da18af8752c5804f48f4c41caf -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/users/trashed" 
```
```javascript
const url = new URL("/api/users/trashed");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/trashed", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users/trashed`


<!-- END_9de992da18af8752c5804f48f4c41caf -->

<!-- START_fc1e4f6a697e3c48257de845299b71d5 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/users" 
```
```javascript
const url = new URL("/api/users");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users`


<!-- END_fc1e4f6a697e3c48257de845299b71d5 -->

<!-- START_12e37982cc5398c7100e59625ebb5514 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/users" 
```
```javascript
const url = new URL("/api/users");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/users", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/users`


<!-- END_12e37982cc5398c7100e59625ebb5514 -->

<!-- START_8653614346cb0e3d444d164579a0a0a2 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/users/1" 
```
```javascript
const url = new URL("/api/users/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/users/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/users/{user}`


<!-- END_8653614346cb0e3d444d164579a0a0a2 -->

<!-- START_48a3115be98493a3c866eb0e23347262 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/users/1" 
```
```javascript
const url = new URL("/api/users/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/users/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/users/{user}`

`PATCH api/users/{user}`


<!-- END_48a3115be98493a3c866eb0e23347262 -->

<!-- START_d2db7a9fe3abd141d5adbc367a88e969 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/users/1" 
```
```javascript
const url = new URL("/api/users/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/users/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/users/{user}`


<!-- END_d2db7a9fe3abd141d5adbc367a88e969 -->

<!-- START_f87d568af345c2e37049ca0b695ccfc4 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/profiles" 
```
```javascript
const url = new URL("/api/profiles");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/profiles", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/profiles`


<!-- END_f87d568af345c2e37049ca0b695ccfc4 -->

<!-- START_40818362204069c5411256a196e75ebe -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/profiles" 
```
```javascript
const url = new URL("/api/profiles");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/profiles", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/profiles`


<!-- END_40818362204069c5411256a196e75ebe -->

<!-- START_46609a0d3fe621a81e9dead314439f47 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/profiles/1" 
```
```javascript
const url = new URL("/api/profiles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/profiles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/profiles/{profile}`


<!-- END_46609a0d3fe621a81e9dead314439f47 -->

<!-- START_fad3fef051972c5811b8c1e0b06b277a -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/profiles/1" 
```
```javascript
const url = new URL("/api/profiles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/profiles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/profiles/{profile}`

`PATCH api/profiles/{profile}`


<!-- END_fad3fef051972c5811b8c1e0b06b277a -->

<!-- START_a84b1a1e5f6535ad6731d9ec6ad47634 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/profiles/1" 
```
```javascript
const url = new URL("/api/profiles/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/profiles/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/profiles/{profile}`


<!-- END_a84b1a1e5f6535ad6731d9ec6ad47634 -->

<!-- START_10633908636252dc838d3a5bd392f07c -->
## api/settings
> Example request:

```bash
curl -X GET -G "/api/settings" 
```
```javascript
const url = new URL("/api/settings");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/settings", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/settings`


<!-- END_10633908636252dc838d3a5bd392f07c -->

<!-- START_8cc4caf985da492764905dc92521c0e8 -->
## api/settings/{setting}
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "/api/settings/1" 
```
```javascript
const url = new URL("/api/settings/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/settings/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/settings/{setting}`


<!-- END_8cc4caf985da492764905dc92521c0e8 -->

<!-- START_917d23c48e8af6a33fc5fc88cdfc27e2 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "/api/policy/password" 
```
```javascript
const url = new URL("/api/policy/password");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/policy/password", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/policy/password`


<!-- END_917d23c48e8af6a33fc5fc88cdfc27e2 -->

<!-- START_3caeacd41ba611bf5f976fb9824fdea3 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "/api/policy/password" 
```
```javascript
const url = new URL("/api/policy/password");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->post("/api/policy/password", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/policy/password`


<!-- END_3caeacd41ba611bf5f976fb9824fdea3 -->

<!-- START_85fb16dcf6f16f219c93c2b189bdf1c4 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "/api/policy/password/1" 
```
```javascript
const url = new URL("/api/policy/password/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->get("/api/policy/password/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/policy/password/{password}`


<!-- END_85fb16dcf6f16f219c93c2b189bdf1c4 -->

<!-- START_9214b4d6e6d679931afde90f718ff2a6 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "/api/policy/password/1" 
```
```javascript
const url = new URL("/api/policy/password/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->put("/api/policy/password/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`PUT api/policy/password/{password}`

`PATCH api/policy/password/{password}`


<!-- END_9214b4d6e6d679931afde90f718ff2a6 -->

<!-- START_945a8e53b7194d88f48bc56fe0483b4d -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "/api/policy/password/1" 
```
```javascript
const url = new URL("/api/policy/password/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```
```php

$client = new \GuzzleHttp\Client();
$response = $client->delete("/api/policy/password/1", [
]);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`DELETE api/policy/password/{password}`


<!-- END_945a8e53b7194d88f48bc56fe0483b4d -->



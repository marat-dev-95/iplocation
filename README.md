# UI

### Request

`GET http://185.100.67.199/api/getLocation?ip_address=158.19.155.205

### Response

    {
        "data": [
            {
                "country_name": "United States",
                "ip_address": "158.19.155.205"
            }
        ]
    }

# API
## Create
### Request

`POST http://185.100.67.199/api/iplocation

    {
        "ip_locations": [{"ip":"158.19.155.204", "country_name": "America"}, {"ip":"158.19.155.204", "country_name":"Africe"}]
    }

### Response

    {
        "data": [
            {
                "country_name": "America",
                "ip_address": "158.19.155.204"
            },
            {
                "country_name": "Africa",
                "ip_address": "158.19.155.204"
            }
        ]
    }
    
    
## Read
### Request

`GET http://185.100.67.199/api/iplocation

    {
        "ip_addresses": ["158.19.155.205"]
    }

### Response

    {
        "data": [
            {
                "country_name": "United States",
                "ip_address": "158.19.155.205"
            }
        ]
    }
    

## Update
### Request

`PUT http://185.100.67.199/api/iplocation

    {
        "ip_locations": [{"ip":"158.19.155.204", "country_name": "America"}, {"ip":"158.19.155.204", "country_name":"Africe"}]
    }

### Response

    {
        "data": [
            {
                "country_name": "America",
                "ip_address": "158.19.155.204"
            },
            {
                "country_name": "Africa",
                "ip_address": "158.19.155.204"
            }
        ]
    }
    
## Delete
### Request

`DELETE http://185.100.67.199/api/iplocation

    {
        "ip_addresses": ["158.19.155.205"]
    }
    

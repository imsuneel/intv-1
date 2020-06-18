### Github Repository
    [Github Repository](https://github.com/imsuneel/intv-1.git)


### API Collection
    [Postman Collection](https://documenter.getpostman.com/view/3893823/Szzn4vEd?version=latest)



## Process
- Pull this repository.
- Updated database details in .env file.
- composer update
- php artisan migrate
- php artisan db:seed
- php artisan key:generate
- php artisan jwt:secret
- php artisan serve


### HTTP Status Code  
| HTTP Status Code       | HTTP Description      | Description     |
| :------------- | :----------: | -----------: |
|  200 | OK   | Success Response    |
|  422 | Unprocessable Entity   | Validation Fail    |
|  400 | Bad Request   | Request Fail    |
|  401 | Unauthenticated   | authorization failure    |
|  500 | Internal Server Error   | Server Error   |








## Cognitum task

### First run
To build project please run `make build`.

### Start project
To start project please run `make start`.

### Tests
To run tests please run `make test`.
Coverage report is available in `tests/coverage` directory.

### Insomnia/Postman
Please import `collection.json` file to your Insomnia/Postman.

## Solution
I have created two modules: 
1. Duties that store events activities from rooster files
2. Documents that handle uploading

When using Insomnia/Postman please first upload a file with the `POST` request to `/api/documents/upload` endpoint.
Then you can import duties from the uploaded file with the `POST` request to `/api/duties/import` endpoint providing document id from previous endpoint.
Then you can use the `GET` request to `/api/duties/events` endpoint to get the events activities from the uploaded file.

## Background
Here are Wag! we deal with dogs, people, and services. Each dog has exactly one owner, but an owner can have multiple dogs, as long as they have different names. Each person is either an owner or a worker, but the same person can not be both. Phone numbers are supposed to be unique across all people. Each service may be classified as "walking", "grooming", "boarding", or "sitting". A service involves one worker and one dog.

# Setup
```
docker build -t sql_challenge .
docker run -d -p 3306:3306 -t sql_challenge
```

## Challenge
The `dataset` table contains all the data you will need. Create and populate a normalized schema that captures it all. Make the necessary keys and indexes that enforce all business constraints. The dataset contains repeating data, so the latter instance should overwrite the former one, e.g., same dog with a different age or same person with a different location.

Create a view `agenda(worker_phone, worker_name, owner_phone, owner_name, dog_name, dog_age, distance, service_type, service_start, service_duration)` that shows the latest service for dogs and workers. The service_duration should be formatted as HH:MM:SS. The distance between owner and worker should be in miles. Use the provided gps_distance() function, which returns the distance in kilometers.

Put all of your code in `solution.sql`, run it, and check your work with `php test.php`. YOUR CODE MUST BE IDEMPOTENT. Send us an email with a link to the solution or a zip

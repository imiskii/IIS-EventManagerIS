File structure:
    -index.php -> serves as the starting point for all requests
        -config: contains functions that are shared by multiple files
        -endpoints: php code that handles a specific request
        -methods: a total of 4 files where each handles a specific HTTP Method -> GET/POST/PUT/DELETE
    -.htaccess -> used by Apache servers (we use it to redirect all traffic to index.php - not including directories or "pictures")

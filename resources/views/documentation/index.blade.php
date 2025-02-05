<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        code {
            background-color: #f4f4f4;
            padding: 5px;
            border-radius: 5px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .response {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
        }
        .endpoint {
            background-color: #34495e;
            color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>API Documentation</h1>

    <h2>Base URL</h2>
    <pre><code>https://nadjatarassovatestpage.website/api</code></pre>

    <h2>Authentication</h2>
    <p>This API uses <strong>Laravel Sanctum</strong> for authentication. To access the endpoints that require authentication, you need to pass a valid Bearer token in the request headers.</p>
    <p>The token is obtained by calling the <code>POST /token</code> endpoint.</p>

    <h3>1. Obtain Authentication Token</h3>
    <div class="endpoint">
        <p><strong>POST</strong> /token</p>
    </div>
    <p><strong>Description</strong>: This endpoint generates an authentication token for the user. The user needs to provide credentials (email).</p>
    <h4>Request body (JSON):</h4>
    <pre><code>{
  "email": "user@example.com"
}</code></pre>

    <h4>Response:</h4>
    <p><strong>Success (200):</strong></p>
    <div class="response">
        <pre><code>{
  "status": true,
  "token": "your_generated_token_here"
}</code></pre>
    </div>

    <h3>2. List Users</h3>
    <div class="endpoint">
        <p><strong>GET</strong> /users</p>
    </div>
    <p><strong>Description</strong>: Returns a list of all users.</p>
    <h4>Response:</h4>
    <p><strong>Success (200):</strong></p>
    <div class="response">
        <pre><code>[
            "count": 6
            "links": 
                {
                    next: "https://abzagency.test/api/users?page=2", 
                    prev: null
                }
            "page": 1
            "success": true
            "total_pages": 10
            "total_users": 47
            "users":[
                
              {
                "id": 1,
                "name": "John Doe",
                "email": "john.doe@example.com",
                "created_at": "2025-01-01T12:00:00.000000Z",
                "updated_at": "2025-01-01T12:00:00.000000Z"
              },
              {
                "id": 2,
                "name": "Jane Doe",
                "email": "jane.doe@example.com",
                "created_at": "2025-01-01T12:00:00.000000Z",
                "updated_at": "2025-01-01T12:00:00.000000Z"
              }
            ]
]</code></pre>
    </div>

    <h3>3. View a Single User</h3>
    <div class="endpoint">
        <p><strong>GET</strong> /users/{user}</p>
    </div>
    <p><strong>Description</strong>: Returns a single user's details by their ID.</p>
    <p><strong>Parameters</strong>:</p>
    <ul>
        <li><code>user</code> (integer) - The ID of the user you want to fetch.</li>
    </ul>

    <h4>Response:</h4>
    <p><strong>Success (200):</strong></p>
    <div class="response">
        <pre><code>{
            "succes": true,
            "user":{
                "id": 1,
                "name": "John Doe",
                "email": "john.doe@example.com",
                "created_at": "2025-01-01T12:00:00.000000Z",
                "updated_at": "2025-01-01T12:00:00.000000Z"
            }
}</code></pre>
    </div>
    

    <h3>4. List Positions</h3>
    <div class="endpoint">
        <p><strong>GET</strong> /positions</p>
    </div>
    <p><strong>Description</strong>: Returns a list of all positions.</p>

    <h4>Response:</h4>
    <p><strong>Success (200):</strong></p>
    <div class="response">
        <pre><code>[
            "success": true,
            "positions": [
                {
                    "id": 1,
                    "name": "Position 1",
                    "description": "Description of Position 1"
                  },
                  {
                    "id": 2,
                    "name": "Position 2",
                    "description": "Description of Position 2"
                  }
            ]
]</code></pre>
    </div>

    <h2>Authenticated Routes</h2>
    <p>The following routes are protected by the <code>auth:sanctum</code> middleware and require an authenticated user (Bearer token).</p>

    <h3>5. Create a User</h3>
    <div class="endpoint">
        <p><strong>POST</strong> /users</p>
    </div>
    <p><strong>Description</strong>: Creates a new user. This is an authenticated route, so the request must include a valid Bearer token.</p>
    <h4>Request body (JSON):</h4>
    <pre><code>{
  "name": "New User",
  "email": "new.user@example.com",
  "phone": "+380555555",
  "position_id": "1",
}</code></pre>

    <h4>Response:</h4>
    <p><strong>Success (201):</strong></p>
    <div class="response">
        <pre><code>{
            "success": true,
            "user_id": 23,
            "message": "New user successfully registered"
}</code></pre>
    </div>


    <h3>6. Logout</h3>
    <div class="endpoint">
        <p><strong>POST</strong> /logout</p>
    </div>
    <p><strong>Description</strong>: Logs out the authenticated user and invalidates the Bearer token.</p>
    <p><strong>Headers</strong>: <code>Authorization: Bearer &lt;token&gt;</code> (for authenticated users)</p>

    <h4>Response:</h4>
    <p><strong>Success (200):</strong></p>
    <div class="response">
        <pre><code>{
            "status" => true,
            "message" => 'You has been logged out!',
}</code></pre>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .feedback-form {
            margin-bottom: 40px;
        }
        .feedback-form label {
            font-weight: bold;
        }
        .feedback-form input, .feedback-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .feedback-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .feedback-form button:hover {
            background-color: #45a049;
        }
        .feedback-list {
            margin-top: 20px;
        }
        .feedback-item {
            background-color: #f9f9f9;
            border-left: 5px solid #4CAF50;
            padding: 10px;
            margin-bottom: 10px;
        }
        .feedback-item p {
            margin: 5px 0;
        }
        .feedback-item .user {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Feedback Report Page</h1>

    <!-- Feedback Form -->
    <div class="feedback-form">
        <form id="feedbackForm">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="feedback">Your Feedback:</label>
            <textarea id="feedback" name="feedback" rows="4" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>

    <!-- Feedback List -->
    <div class="feedback-list" id="feedbackList">
        <h2>Feedbacks:</h2>
        <!-- Feedback items will be inserted here -->
    </div>
</div>

<script>
    // Handle the form submission
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get values from form
        const name = document.getElementById('name').value;
        const feedback = document.getElementById('feedback').value;

        // Create a feedback item
        const feedbackItem = document.createElement('div');
        feedbackItem.classList.add('feedback-item');

        feedbackItem.innerHTML = `
            <p class="user">${name}</p>
            <p>${feedback}</p>
        `;

        // Append the new feedback item to the feedback list
        document.getElementById('feedbackList').appendChild(feedbackItem);

        // Clear the form
        document.getElementById('feedbackForm').reset();
    });
</script>

</body>
</html>

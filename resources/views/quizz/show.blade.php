@extends('layouts.app')

@section('content')
    <style>
        .answer-form{
            margin-top: 40px;
            margin-bottom: 30px;
        }
        span{
            margin-left:10px ;
        }
        p{
            font-family: 'serif', serif;
            font-size: 40px;
            margin-left: -170px;

            margin-bottom: 65px;
            color: #124d7c;


        }
        .quiz-container {

            max-width: 800px;
            margin: auto;
            margin-top: 40px;
            padding: 20px;
            background-color: #F4F8FC;
            border: 1px solid #28527A;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif; /* A modern font commonly used in IQ tests */
        }

        .question-container {
            display: flex;
            flex-direction: row; /* Align side by side */
            margin-bottom: 20px;
            border-bottom: 2px solid #28527A; /* Line between question and answers */
        }

        .question {
            flex-basis: 50%;
            padding-right: 20px;
            text-align: left; /* Align text to the left */
        }

        .question img {
            height: auto;
            width: 379px;
            object-fit: contain;
            border-radius: 5px;
            display: block; /* Ensure it's a block to center */
            margin: 10px auto; /* Center image */
        }

        .answers {
            display: flex;
            flex-wrap: wrap;
        }

        .answer-option {
            width: calc(50% - 20px); /* Adjust width for two items per line */
            margin: 10px; /* Add margin for spacing */
            text-align: center;
            padding: 10px;
            border: 1px solid #28527A;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            transition: background-color 0.2s ease;
            box-sizing: border-box;
            position: relative;
            max-width: 140px;
            margin-right: 20px;
        }

        .answer-option:nth-child(odd) {
            margin-right: 20px; /* Add right margin to odd items for spacing */
        }

        .answer-option:hover {
            background-color: #E6F2FF; /* Light blue background on hover */
        }

        .answer-option img {
            max-width: 100%; /* Set a max-width to contain the image */
            max-height: 100px; /* Set a max-height for the image */
            object-fit: contain; /* Contain the image within the bounds */
            margin: 0 auto; /* Center the image */
            display: block;
        }

        .answer-option label {
            display: block;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }

        .answer-option.selected {
            border-color: #28527A; /* Highlight selected option */
        }

        .selected {
            background-color: #E6F2FF; /* Light blue background to indicate selection */
        }

        button {
            display: block;
            margin: 0px auto 20px; /* Adjusted button placement */
            padding: 10px 20px;
            background-color: #28527A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .answer-image {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 10px 0;
        }

        table{
            margin-top: 10px;
        }

        .back-button {
            display: block;
            margin: 20px auto;
        }



        .answer-option:hover {
            background-color: #E6F2FF;
        }

        .answer-option img {
            max-width: 100%; /* Set a max-width to contain the image */
            max-height: 100px; /* Set a max-height for the image */
            object-fit: contain; /* Contain the image within the bounds */
            margin: 0 auto; /* Center the image */
            display: block;
        }

        .answer-option input[type="radio"] {
            display: none; /* Hide the radio button */
        }
        .answer-option label {
            display: block;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }

        .answer-option.selected {
            border-color: #28527A; /* Highlight selected option */
        }
        .selected {
            background-color: #E6F2FF; /* Light blue background to indicate selection */
        }
        .hidden {
            display: none;
        }
        #box-wrapper {
            display: flex;
            flex-wrap: wrap;
        }

        #box-wrapper > div {
            flex: 1 1 calc(50% - 2px);
            border: 1px solid black;
        }


        /* a */
        #box-wrapper > div:nth-child(1) {
            order: 0;
        }

        /* d */
        #box-wrapper > div:nth-child(4) {
            order: 1;
        }

        /* b */
        #box-wrapper > div:nth-child(2) {
            order: 2;
        }

        /* e */
        #box-wrapper > div:nth-child(5) {
            order: 3;
        }

        /* c */
        #box-wrapper > div:nth-child(3) {
            order: 4;
        }

        /* e */
        #box-wrapper > div:nth-child(6) {
            order: 5;
        }

        .img-questionion{
            width: 379px;
            height: 211px;
        }




        .quiz-bubbles {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .quiz-bubbles .bubble {
            width: 40px;
            height: 40px;

            padding-top: 8px;
            border-radius: 50%;
            background-color: #ccc;
            margin: 0 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: white;
        }

        .quiz-bubbles .bubble.current {
            background-color: #28527A;
        }

        .quiz-bubbles .bubble.answered {
            background-color: #a962d3;
        }


        .back-button,
        .next-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28527A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button::before,
        .next-button::after {
            content: '';
            display: inline-block;
            width: 0;
            height: 0;
            border-style: solid;
            position: relative;
            top: 2px;
        }

        .back-button::before {
            border-width: 10px 10px 10px 0;
            border-color: transparent #fff transparent transparent;
            margin-right: 10px;
        }

        .next-button::after {
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #fff;
            margin-left: 10px;
        }

        .back-button:hover,
        .next-button:hover {
            background-color: #124d7c;
        }

        /* Style for table cells */
        td {
            padding: 10px;
            text-align: center;
        }

        /* Style for the arrow buttons */
        .arrow-button {
            background-color: #28527A;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        /* Style for left arrow */
        .left-arrow::before {
            content: '\2039'; /* Unicode for left-pointing arrow */
            font-size: 18px;
            margin-right: 5px;
        }

        /* Style for right arrow */
        .right-arrow::after {
            content: '\203A'; /* Unicode for right-pointing arrow */
            font-size: 18px;
            margin-left: 5px;
        }

        /* Hover effect */
        .arrow-button:hover {
            background-color: #124d7c;
        }
    </style>
    <div class="quiz-container">
        @foreach($quiz->quizDetails as $index => $detail)
            @php
                $questionCount = count($quiz->quizDetails);
            @endphp
            <div class="question-container {{ $index === 0 ? '' : 'hidden' }}" id="question-container-{{ $detail->id }}">
                <div class="question">
                    <!-- Question Image and Text -->
                    <center>
                        <div class="question-counter" style="display: flex; align-items: center; justify-content: flex-start; font-size: 30px; margin-bottom: 20px;">
                            <strong>{{ $index + 1 }} / {{ $totalQuestions }}</strong>
                        </div>

                    </center>
                    <center>
                        <p style="max-width: 600px; margin: 0 auto;">
                            <strong>{{ $detail->question->question_text }}</strong>
                        </p>
                    </center>
                    @if($detail->question->question_image)
                        <img class="img-question" src="{{ asset('storage/questions/'.$detail->question->question_image) }}" alt="Question Image">
                    @endif
                </div>
                <div class="answers">
                    <form method="POST" class="answer-form" name="form">
                        <span>Please choose an answer:</span>
                        <div id="box-wrapper">
                            @csrf
                            @foreach($detail->question->answers as $answer)
                                <div class="answer-option {{ $detail->user_answer == $answer->id ? 'selected' : '' }}" data-answer-id="{{ $answer->id }}">
                                    <img src="{{ asset('storage/answers/'.$answer->answer_image) }}" alt="Answer Image" class="answer-image">
                                    @if($answer->answer_text)
                                        <label>{{ $answer->answer_text }}</label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="answer_id" value="">
                        <input type="hidden" name="quiz_detail_id" value="{{ $detail->id }}">
                    </form>
                </div>
                <div id="loading-spinner" style="display: none;">
                    <!-- Replace this with your actual loading spinner -->
                    <p>Loading...</p>
                </div>
            </div>
        @endforeach

    </div>
    <center>
        <table>
            <tr>
                <td>
                    <button onclick="navigate(-1)" class="arrow-button left-arrow"></button>
                </td>
                <td>
                    <div class="quiz-bubbles">
                        @foreach($quiz->quizDetails as $index => $detail)
                            <div class="bubble {{ $index === 0 ? 'current' : '' }}" onclick="navigateToQuestion({{ $index }})">{{ $index +1}}</div>
                        @endforeach
                    </div>
                </td>
                <td>
                    <button onclick="navigate(1)" class="arrow-button right-arrow"></button>
                </td>
                <td>
                    <button style="display: none" onclick="window.location.href='{{ route('order.show', $quiz->id) }}'" class="Result">Get My Result</button>
                </td>
            </tr>
        </table>
    </center>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function checkLastQuestion(index) {
                const resultElement = document.querySelector('.Result');
                if (resultElement) {
                    if (index === {{$totalQuestions}} -1) {
                        resultElement.style.display = ''; // Removing the 'display: none;' style
                    } else {
                        resultElement.style.display = 'none'; // Setting 'display: none;'
                    }
                }
            }

            // Function to navigate to a specific question
            window.navigateToQuestion = function(index) {
                const questionContainers = document.querySelectorAll('.question-container');
                questionContainers.forEach(container => container.classList.add('hidden'));
                questionContainers[index].classList.remove('hidden');
                updateBubbleStatus(index);
                currentQuestionIndex = index;
                checkLastQuestion(currentQuestionIndex);
            };

            // Function to update the styling of bubbles based on the current question
            function updateBubbleStatus(index) {
                const bubbles = document.querySelectorAll('.quiz-bubbles .bubble');
                bubbles.forEach((bubble, i) => {
                    bubble.classList.remove('current');
                    if (i === index) {
                        bubble.classList.add('current');
                    } else if (i !== index) {
                        bubble.classList.remove('current');
                    }
                });
            }

        });
    </script>


    <script>
        function updateNavigationBubbles(index) {
            const bubbles = document.querySelectorAll('.quiz-bubbles .bubble');
            bubbles.forEach((bubble, i) => {
                bubble.classList.remove('current');
                if (i === index) {
                    bubble.classList.add('current');
                }
            });
        }
        function checkLastQuestion(index) {
            const resultElement = document.querySelector('.Result');
            if (resultElement) {
                if (index === {{$totalQuestions}} -1) {
                    resultElement.style.display = ''; // Removing the 'display: none;' style
                } else {
                    resultElement.style.display = 'none'; // Setting 'display: none;'
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const questionContainers = document.querySelectorAll('.question-container');
            let currentQuestionIndex = 0;
            const totalQuestions = questionContainers.length;

            // Function to handle answer selection
            function handleAnswerClick(answerOption, form) {
                // Deselect all other options
                form.querySelectorAll('.answer-option').forEach(function(option) {
                    option.classList.remove('selected');
                });

                // Select the clicked option
                answerOption.classList.add('selected');

                // Set the hidden input value to the selected answer ID
                const answerId = answerOption.getAttribute('data-answer-id');
                console.log('Selected answer ID:', answerId); // Log the answer ID to the console
                form.querySelector('input[name="answer_id"]').value = answerId;

                // Prepare the form data for the Axios POST request
                const formData = new FormData(form);

                // Get the quiz_detail_id from the hidden input field
                const quizDetailId = form.querySelector('input[name="quiz_detail_id"]').value;

                // Set the post URL
                const postUrl = `/quiz/update-answer/${quizDetailId}`; // Update URL to include quiz_detail_id

                // Show the loading spinner
                document.getElementById('loading-spinner').style.display = 'block';

                // Submit the form data using Axios
                axios.post(postUrl, formData)
                    .then(function(response) {
                        console.log(response.data.message);
                        // Navigate to the next question
                        // Navigate to the next question
                        if (currentQuestionIndex < questionContainers.length - 1) {
                            questionContainers[currentQuestionIndex].classList.add('hidden');
                            questionContainers[++currentQuestionIndex].classList.remove('hidden');
                            updateNavigationBubbles(currentQuestionIndex);  // Update navigation bubbles
                        }
                    })
                    .catch(function(error) {
                        console.error(error.response.data); // Log any validation errors
                    })
                    .finally(function() {
                        // Hide the loading spinner
                        document.getElementById('loading-spinner').style.display = 'none';
                    });
            }

            // Add click event listeners to answer options
            questionContainers.forEach(container => {
                const answers = container.querySelectorAll('.answer-option');
                const form = container.querySelector('.answer-form');

                answers.forEach(answer => {
                    answer.addEventListener('click', function() {
                        handleAnswerClick(this, form);
                    });
                });
            });

// Handle form submission
            document.querySelectorAll('.answer-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const quizDetailId = this.querySelector('input[name="quiz_detail_id"]').value;
                    const selectedAnswerId = this.querySelector('input[name="answer_id"]').value;

                    if (!selectedAnswerId) {
                        alert('Please select an answer.');
                        return;
                    }

                    const formData = new FormData(this);
                    formData.append('answer_id', selectedAnswerId);
                    const postUrl = `/quiz/update-answer/${quizDetailId}`; // Updated URL to include quiz_detail_id
                    // Submit the form data using Axios
                    axios.post(postUrl, formData)
                        .then(function(response) {
                            console.log(response.data.message);
                            // Navigate to the next question
                            if (currentQuestionIndex < questionContainers.length - 1) {
                                questionContainers[currentQuestionIndex].classList.add('hidden');
                                questionContainers[++currentQuestionIndex].classList.remove('hidden');

                            }
                        })
                        .catch(function(error) {
                            console.error(error.response.data); // Log any validation errors
                        });
                });
            });


            // Function to navigate between questions
            window.navigate = function(step) {
                const newIndex = currentQuestionIndex + step;
                if (newIndex >= 0 && newIndex < questionContainers.length) {
                    questionContainers[currentQuestionIndex].classList.add('hidden');
                    questionContainers[newIndex].classList.remove('hidden');
                    const bubbles = document.querySelectorAll('.quiz-bubbles .bubble');
                    bubbles.forEach((bubble, i) => {
                        bubble.classList.remove('current');
                        if (i === newIndex) {
                            bubble.classList.add('current');
                        } else if (i !== newIndex) {
                            bubble.classList.remove('current');

                        }
                    });
                    currentQuestionIndex = newIndex;
                    checkLastQuestion(currentQuestionIndex)
                }
            };
        });




    </script>



    <!-- Remove this line if you're not using Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@endsection

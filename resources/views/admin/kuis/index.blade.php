@extends('layouts.development.development')

@section('title', 'Quiz - BUBA')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-pink-50 to-blue-50 px-6 py-8">

    {{-- Header --}}
    <div class="max-w-6xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">
                    Quiz Buba 🧩
                </h1>

                <p class="text-gray-500 mt-1">
                    Yuk belajar sambil bermain!
                </p>
            </div>

            {{-- Score --}}
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm">
                <span class="text-2xl">⭐</span>

                <div>
                    <p class="text-xs text-gray-500">
                        Skor
                    </p>

                    <p id="score" class="text-xl font-extrabold text-yellow-500">
                        0
                    </p>
                </div>
            </div>

        </div>


        {{-- Progress --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 mb-6">

            <div class="flex justify-between items-center mb-3">

                <span class="font-bold text-gray-700">
                    Soal
                    <span id="questionNumber">1</span>
                    dari 5
                </span>

                <span id="progressText"
                      class="text-sm font-semibold text-gray-500">
                    20%
                </span>

            </div>

            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">

                <div id="progressBar"
                     class="bg-yellow-400 h-3 rounded-full transition-all duration-500"
                     style="width: 20%">
                </div>

            </div>

        </div>


        {{-- Quiz Card --}}
        <div class="bg-white rounded-3xl shadow-md p-6 md:p-10">

            {{-- Question --}}
            <div class="text-center">

                <div id="questionImage"
                     class="w-40 h-40 mx-auto rounded-3xl bg-yellow-100 flex items-center justify-center text-8xl mb-6">
                    🍎
                </div>

                <h2 id="question"
                    class="text-2xl md:text-3xl font-extrabold text-gray-800">
                    Buah apakah ini?
                </h2>

                <p class="text-gray-500 mt-2">
                    Pilih jawaban yang benar 😊
                </p>

            </div>


            {{-- Options --}}
            <div id="options"
                 class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-8">

                {{-- Akan diisi menggunakan JavaScript --}}

            </div>


            {{-- Feedback --}}
            <div id="feedback"
                 class="hidden mt-6 rounded-2xl p-4 text-center font-bold">
            </div>


            {{-- Next --}}
            <div class="flex justify-end mt-7">

                <button id="nextButton"
                        type="button"
                        disabled
                        class="px-7 py-3 rounded-full bg-gray-300 text-gray-500 font-bold cursor-not-allowed">

                    Lanjut →

                </button>

            </div>

        </div>

    </div>

</div>


<script>

const questions = [

    {
        question: "Buah apakah ini?",
        image: "🍎",
        answers: [
            ["🍎", "Apel"],
            ["🍌", "Pisang"],
            ["🍉", "Semangka"],
            ["🍊", "Jeruk"]
        ],
        correct: "Apel"
    },

    {
        question: "Hewan apakah ini?",
        image: "🐱",
        answers: [
            ["🐶", "Anjing"],
            ["🐱", "Kucing"],
            ["🐰", "Kelinci"],
            ["🐮", "Sapi"]
        ],
        correct: "Kucing"
    },

    {
        question: "Warna apakah ini?",
        image: "🔴",
        answers: [
            ["🔴", "Merah"],
            ["🔵", "Biru"],
            ["🟢", "Hijau"],
            ["🟡", "Kuning"]
        ],
        correct: "Merah"
    },

    {
        question: "Bentuk apakah ini?",
        image: "⚪",
        answers: [
            ["🔺", "Segitiga"],
            ["🟦", "Persegi"],
            ["⚪", "Lingkaran"],
            ["⭐", "Bintang"]
        ],
        correct: "Lingkaran"
    },

    {
        question: "Manakah angka tiga?",
        image: "3️⃣",
        answers: [
            ["1️⃣", "Satu"],
            ["2️⃣", "Dua"],
            ["3️⃣", "Tiga"],
            ["4️⃣", "Empat"]
        ],
        correct: "Tiga"
    }

];


let currentQuestion = 0;
let score = 0;
let selectedAnswer = null;


const questionNumber =
    document.getElementById('questionNumber');

const progressText =
    document.getElementById('progressText');

const progressBar =
    document.getElementById('progressBar');

const question =
    document.getElementById('question');

const questionImage =
    document.getElementById('questionImage');

const options =
    document.getElementById('options');

const feedback =
    document.getElementById('feedback');

const nextButton =
    document.getElementById('nextButton');

const scoreElement =
    document.getElementById('score');


function loadQuestion() {

    const data = questions[currentQuestion];

    selectedAnswer = null;

    questionNumber.textContent =
        currentQuestion + 1;

    question.textContent =
        data.question;

    questionImage.textContent =
        data.image;


    const progress =
        ((currentQuestion + 1) / questions.length) * 100;

    progressBar.style.width =
        progress + '%';

    progressText.textContent =
        progress + '%';


    feedback.classList.add('hidden');

    feedback.textContent = '';


    nextButton.disabled = true;

    nextButton.className =
        'px-7 py-3 rounded-full bg-gray-300 text-gray-500 font-bold cursor-not-allowed';


    options.innerHTML = '';


    data.answers.forEach((answer) => {

        const button =
            document.createElement('button');

        button.type = 'button';

        button.className =
            'option-card bg-gray-50 border-2 border-gray-100 rounded-2xl p-5 text-left hover:border-yellow-300 hover:bg-yellow-50 transition';


        button.innerHTML = `

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center text-3xl shadow-sm">
                    ${answer[0]}
                </div>

                <span class="text-lg font-bold text-gray-700">
                    ${answer[1]}
                </span>

            </div>

        `;


        button.addEventListener('click', () => {

            selectAnswer(
                button,
                answer[1]
            );

        });


        options.appendChild(button);

    });

}


function selectAnswer(button, answer) {

    if (selectedAnswer !== null) {
        return;
    }


    selectedAnswer = answer;

    const correct =
        questions[currentQuestion].correct;


    const allOptions =
        document.querySelectorAll('.option-card');


    allOptions.forEach(option => {

        option.disabled = true;

    });


    if (answer === correct) {

        score += 20;

        scoreElement.textContent =
            score;


        button.classList.remove(
            'bg-gray-50',
            'border-gray-100'
        );

        button.classList.add(
            'bg-green-100',
            'border-green-400'
        );


        feedback.textContent =
            '🎉 Benar! Hebat sekali!';

        feedback.className =
            'mt-6 rounded-2xl p-4 text-center font-bold bg-green-100 text-green-700';

    }

    else {

        button.classList.remove(
            'bg-gray-50',
            'border-gray-100'
        );

        button.classList.add(
            'bg-red-100',
            'border-red-400'
        );


        feedback.textContent =
            '😊 Belum tepat. Yuk coba soal berikutnya!';

        feedback.className =
            'mt-6 rounded-2xl p-4 text-center font-bold bg-red-100 text-red-700';

    }


    nextButton.disabled = false;

    nextButton.className =
        'px-7 py-3 rounded-full bg-yellow-400 text-gray-800 font-bold hover:bg-yellow-500 transition cursor-pointer';

}


nextButton.addEventListener('click', () => {

    if (currentQuestion < questions.length - 1) {

        currentQuestion++;

        loadQuestion();

    }

    else {

        showResult();

    }

});


function showResult() {

    document.querySelector('.max-w-6xl').innerHTML = `

        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded-3xl shadow-md p-10 text-center">

                <div class="text-7xl mb-5">
                    🏆
                </div>

                <h2 class="text-4xl font-extrabold text-gray-800">
                    Quiz Selesai!
                </h2>

                <p class="text-gray-500 mt-3">
                    Wah, kamu sudah menyelesaikan semua soal!
                </p>


                <div class="my-8 bg-yellow-50 rounded-3xl p-7">

                    <p class="text-gray-500 font-semibold">
                        Skor Kamu
                    </p>

                    <p class="text-6xl font-extrabold text-yellow-500 mt-2">
                        ${score}
                    </p>

                    <p class="text-gray-500 mt-2">
                        dari 100
                    </p>

                </div>


                <button
                    type="button"
                    onclick="location.reload()"
                    class="px-8 py-3 rounded-full bg-yellow-400 text-gray-800 font-bold hover:bg-yellow-500 transition">

                    🔄 Coba Lagi

                </button>

            </div>

        </div>

    `;

}


loadQuestion();

</script>

@endsection
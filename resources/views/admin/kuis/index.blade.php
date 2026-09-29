@extends('layouts.admin.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-pink-50 via-yellow-50 to-blue-50 p-6">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Kuis Buba
            </h1>
            <p class="mt-1 text-gray-500">
                Latihan pengetahuan dasar untuk anak usia dini
            </p>
        </div>

        <div class="rounded-2xl bg-white px-5 py-3 shadow-sm">
            <span class="text-sm text-gray-500">Skor</span>
            <div id="score" class="text-2xl font-bold text-pink-500">
                0
            </div>
        </div>
    </div>

    <!-- Quiz Card -->
    <div class="mx-auto max-w-4xl">

        <div class="overflow-hidden rounded-3xl bg-white shadow-lg">

            <!-- Progress -->
            <div class="border-b border-gray-100 p-5">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="font-semibold text-gray-600">
                        Pertanyaan
                        <span id="questionNumber">1</span>
                        dari 5
                    </span>

                    <span id="progressText" class="font-semibold text-pink-500">
                        20%
                    </span>
                </div>

                <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                    <div
                        id="progressBar"
                        class="h-full rounded-full bg-pink-400 transition-all duration-500"
                        style="width: 20%">
                    </div>
                </div>
            </div>

            <!-- Question -->
            <div id="quizContent" class="p-8">

                <div class="mb-6 text-center">

                    <div
                        id="questionIcon"
                        class="mx-auto mb-5 flex h-32 w-32 items-center justify-center rounded-full bg-yellow-100 text-7xl">
                        🍎
                    </div>

                    <h2
                        id="question"
                        class="text-2xl font-bold leading-relaxed text-gray-800">
                        Buah apakah yang berwarna merah?
                    </h2>

                    <p class="mt-2 text-sm text-gray-400">
                        Pilih jawaban yang benar
                    </p>
                </div>

                <!-- Options -->
                <div id="options" class="grid gap-4 md:grid-cols-2">

                </div>

                <!-- Feedback -->
                <div
                    id="feedback"
                    class="mt-6 hidden rounded-2xl p-4 text-center font-semibold">
                </div>

                <!-- Next -->
                <div class="mt-6 text-center">
                    <button
                        id="nextButton"
                        onclick="nextQuestion()"
                        class="hidden rounded-2xl bg-pink-500 px-8 py-3 font-bold text-white shadow-md transition hover:bg-pink-600">
                        Pertanyaan Berikutnya →
                    </button>
                </div>

            </div>

            <!-- Result -->
            <div
                id="result"
                class="hidden p-10 text-center">

                <div class="mb-5 text-7xl">
                    🎉
                </div>

                <h2 class="text-3xl font-bold text-gray-800">
                    Kuis Selesai!
                </h2>

                <p class="mt-3 text-gray-500">
                    Hebat! Kamu sudah menyelesaikan kuis Buba.
                </p>

                <div class="mx-auto my-8 max-w-sm rounded-3xl bg-yellow-50 p-6">
                    <p class="text-sm font-semibold text-gray-500">
                        Skor Kamu
                    </p>

                    <p
                        id="finalScore"
                        class="mt-2 text-5xl font-bold text-yellow-500">
                        0
                    </p>

                    <p
                        id="resultMessage"
                        class="mt-3 font-semibold text-gray-700">
                    </p>
                </div>

                <button
                    onclick="restartQuiz()"
                    class="rounded-2xl bg-pink-500 px-8 py-3 font-bold text-white shadow-md transition hover:bg-pink-600">
                    🔄 Ulangi Kuis
                </button>

            </div>

        </div>

    </div>

</div>


<script>

const questions = [

    {
        icon: "🍎",
        question: "Buah apakah yang berwarna merah?",
        options: [
            "Apel",
            "Pisang",
            "Jeruk",
            "Anggur"
        ],
        answer: "Apel"
    },

    {
        icon: "🐱",
        question: "Hewan apakah yang berbunyi 'Meong'?",
        options: [
            "Ayam",
            "Kucing",
            "Sapi",
            "Kambing"
        ],
        answer: "Kucing"
    },

    {
        icon: "🔴",
        question: "Warna apakah ini?",
        options: [
            "Biru",
            "Hijau",
            "Merah",
            "Kuning"
        ],
        answer: "Merah"
    },

    {
        icon: "⭐",
        question: "Bentuk apakah yang memiliki lima sudut?",
        options: [
            "Lingkaran",
            "Segitiga",
            "Persegi",
            "Bintang"
        ],
        answer: "Bintang"
    },

    {
        icon: "🔢",
        question: "Berapakah hasil dari 2 + 3?",
        options: [
            "3",
            "4",
            "5",
            "6"
        ],
        answer: "5"
    }

];

let currentQuestion = 0;
let score = 0;
let answered = false;


// Menampilkan pertanyaan
function showQuestion() {

    answered = false;

    const data = questions[currentQuestion];

    document.getElementById("questionNumber").innerText =
        currentQuestion + 1;

    document.getElementById("questionIcon").innerText =
        data.icon;

    document.getElementById("question").innerText =
        data.question;

    document.getElementById("score").innerText =
        score;

    const progress =
        ((currentQuestion + 1) / questions.length) * 100;

    document.getElementById("progressBar").style.width =
        progress + "%";

    document.getElementById("progressText").innerText =
        progress + "%";


    const optionsContainer =
        document.getElementById("options");

    optionsContainer.innerHTML = "";


    data.options.forEach((option, index) => {

        const button = document.createElement("button");

        button.innerText = option;

        button.className =
            "rounded-2xl border-2 border-gray-100 bg-gray-50 p-5 text-lg font-bold text-gray-700 transition hover:border-pink-300 hover:bg-pink-50";

        button.onclick = function () {

            selectAnswer(option, button);

        };

        optionsContainer.appendChild(button);

    });


    document.getElementById("feedback").classList.add("hidden");

    document.getElementById("nextButton").classList.add("hidden");

}


// Ketika jawaban dipilih
function selectAnswer(selected, button) {

    if (answered) {
        return;
    }

    answered = true;

    const correct =
        questions[currentQuestion].answer;

    const allButtons =
        document.querySelectorAll("#options button");


    allButtons.forEach(btn => {

        btn.disabled = true;

        if (btn.innerText === correct) {

            btn.classList.remove(
                "bg-gray-50",
                "border-gray-100"
            );

            btn.classList.add(
                "bg-green-100",
                "border-green-400",
                "text-green-700"
            );

        }

    });


    const feedback =
        document.getElementById("feedback");


    if (selected === correct) {

        score++;

        button.classList.remove(
            "bg-gray-50",
            "border-gray-100"
        );

        button.classList.add(
            "bg-green-100",
            "border-green-400",
            "text-green-700"
        );

        feedback.innerText =
            "🎉 Hebat! Jawaban kamu benar!";

        feedback.className =
            "mt-6 rounded-2xl bg-green-100 p-4 text-center font-semibold text-green-700";

    } else {

        button.classList.remove(
            "bg-gray-50",
            "border-gray-100"
        );

        button.classList.add(
            "bg-red-100",
            "border-red-400",
            "text-red-700"
        );

        feedback.innerText =
            "😊 Tidak apa-apa! Coba lagi di pertanyaan berikutnya.";

        feedback.className =
            "mt-6 rounded-2xl bg-red-100 p-4 text-center font-semibold text-red-700";

    }


    document.getElementById("score").innerText =
        score;

    document.getElementById("nextButton").classList.remove("hidden");

}


// Pertanyaan berikutnya
function nextQuestion() {

    currentQuestion++;

    if (currentQuestion < questions.length) {

        showQuestion();

    } else {

        showResult();

    }

}


// Menampilkan hasil
function showResult() {

    document.getElementById("quizContent")
        .classList.add("hidden");

    document.getElementById("result")
        .classList.remove("hidden");

    document.getElementById("finalScore")
        .innerText =
        score + " / " + questions.length;


    let message = "";

    if (score === 5) {

        message =
            "🌟 Sempurna! Kamu hebat sekali!";

    } else if (score >= 3) {

        message =
            "👏 Bagus! Terus belajar bersama Buba!";

    } else {

        message =
            "💪 Tetap semangat! Coba kuis lagi ya!";

    }


    document.getElementById("resultMessage")
        .innerText = message;

}


// Mengulang kuis
function restartQuiz() {

    currentQuestion = 0;

    score = 0;

    document.getElementById("quizContent")
        .classList.remove("hidden");

    document.getElementById("result")
        .classList.add("hidden");

    showQuestion();

}


// Jalankan pertama kali
showQuestion();

</script>

@endsection

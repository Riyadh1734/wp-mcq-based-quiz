<template>
  <div id="vue-quiz-app">
    <div id="app" class="flex w-full h-screen justify-center items-center">
        <div class="w-full max-w-xl p-3">
            <h1 class="font-bold text-5xl text-center text-indigo-700">
                Simple Quiz
            </h1>
            <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
                <div v-if="idx < count">
                    <p class="text-2xl font-bold">
                        #{{idx+1}} {{questions[idx]['question']}}
                    </p>
                    <label v-for="(answer, index) in questions[idx].answers" :key="index" :for="index"
                        class="block mt-4 border border-gray-300 rounded-lg py-2 px-6 text-lg">
                        <input :id="index" type="radio" class="hidden" :value="index" @change="answered($event)"
                            :disabled="selectedAnswer != ''">
                        {{answer}}
                    </label>
                    <div class="mt-6 flow-root">
                        <button @click="nextQuestion" v-show="selectedAnswer != '' && idx < count - 1"
                            class="float-right bg-indigo-600 text-white text-sm font-bold tracking-wide rounded-full px-5 py-2">
                            Next &gt;
                        </button>
                        <button @click="showResults" v-show="selectedAnswer != '' && idx == count - 1"
                            class="float-right bg-indigo-600 text-white text-sm font-bold tracking-wide rounded-full px-5 py-2">
                            Finish
                        </button>
                    </div>
                </div>
                <div v-else>
                    <h2 class="text-bold text-3xl">Results</h2>
                    <div class="flex justify-start space-x-4 mt-6">
                        <p>Correct Answers: <span class="text-2xl text-green-700 font-bold">{{correctAnswers}}</span>
                        </p>
                        <p>Wrong Answers: <span class="text-2xl text-red-700 font-bold">{{wrongAnswers}}</span></p>
                    </div>
                    <div class="mt-6 flow-root">
                        <button @click="resetQuiz"
                            class="float-right bg-indigo-600 text-white text-sm font-bold tracking-wide rounded-full px-5 py-2">
                            Play again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'App',
   data() {
        return {
            idx: 0,
            selectedAnswer: '',
            correctAnswers: 0,
            wrongAnswers: 0,
            count: 0,
            questions: []
        }
  }, //data
  methods: {
        answered(e) {
            this.selectedAnswer = e.target.value
            if (this.selectedAnswer == this.questions[this.idx].correctAnswer) {
                this.correctAnswers++
            } else {
                this.wrongAnswers++
            }
        },
        nextQuestion() {
            this.idx++
            this.selectedAnswer = ''
            document.querySelectorAll('input').forEach(el => el.checked = false)
        },
        showResults() {
            this.idx++
        },
        resetQuiz() {
            this.idx = 0
            this.selectedAnswer = ''
            this.correctAnswers = 0
            this.wrongAnswers = 0
        }
  }, //methods
  created() {
    if ( wpstarter.quiz ) {
      this.questions = wpstarter.quiz;
      this.count = wpstarter.quiz.length;
    }
  }, //created

}
</script>

<style>

</style>

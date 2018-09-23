<template>
	<form action="#">
		<div class="form-group row">
			<div class="col-sm-10">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" name="random" value="1" id="chooseRandom" v-model="chooseRandom">
					<label class="form-check-label" for="chooseRandom">
						Do you want random to choose question
					</label>
				</div>
			</div>
		</div>
		<div id="numberQuestions" v-show="chooseRandom">
			<div class="form-group">
				<label for="formGroupExampleInput">How many question do you want?</label>
				<input type="number" class="form-control countQuestions" v-model="countQuestions" id="formGroupExampleInput" v-on:change="randomOptions">
			</div>
		</div>
	</form>

</template>

<script>
	export default {
		name: "SelectQuestions",
		data(){
			return {
				chooseRandom: 0,
				countQuestions: 0
			}
		},
		methods: {
			randomChooseQuestions: function(questions, cycles){

				let choosenQuestions = [];
				questions = Array.from(questions);

				for(let $i = 1; $i <= cycles; $i++ ){

					let item = questions[Math.floor(Math.random() * questions.length)];
					let index = questions.indexOf(item);
					choosenQuestions.push(item);

					if (index > -1) {
						questions.splice(index, 1);
					}
				}

				return choosenQuestions;
			},
			randomOptions: function (event) {

				let questions = document.querySelectorAll('.question');
				let counter = document.querySelectorAll('.countQuestions')[0];
				let saveQuestion = document.querySelectorAll('.saveQuestion')[0];

				if( this.countQuestions <= questions.length){

					if( counter.classList.contains('danger') ){

						counter.classList.remove('danger');
						saveQuestion.setAttribute('type', 'submit');
					}

					let randomQuestions = this.randomChooseQuestions(questions, this.countQuestions);

					for (let $i = 0; $i < questions.length; $i++) {
						questions[$i].querySelector(`input[type='checkbox']`).removeAttribute('checked');
					}

					for (let $i = 0; $i < this.countQuestions; $i++){
						randomQuestions[$i].querySelector(`input[type='checkbox']`).setAttribute('checked', true);
					}
				} else{

					if( !counter.classList.contains('danger') ){

						counter.classList.add('danger');
						saveQuestion.setAttribute('type', 'button');
					}


				}

			},
		}
	}
</script>

<style scoped>
</style>
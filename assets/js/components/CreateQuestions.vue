<template>
	<div class="form-group">
		<label for="exampleFormControlSelect1">Number of answers:</label>
		<input type="hidden" name="countQuestions" v-model="countQuestions">
		<select class="form-control" id="exampleFormControlSelect1" name="countAnswers" v-model="countAnswers" required>
			<option selected>Choose...</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<div v-if="countAnswers">
			<a href="#" v-on:click.prevent="addQuestion" class="addQuestion add-icon">
				<i class="fas fa-plus-circle"></i>
			</a>
			<div class="questions form-check"></div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "CreateQuestions",
		data(){
			return {
				countAnswers: '',
				countQuestions: 1,
			}
		},
		methods: {
			addQuestion: function() {

				let wrapper = document.querySelectorAll('.questions')[0];
				let wrap = document.createElement('div');
				let item = document.createElement('div');
				wrap.classList.add('form-group');
				item.classList.add('form-row');

				wrap.innerHTML = `
					<div class="form-row question">
						Question ${this.countQuestions}: <input type="text" name="${ 'question'+this.countQuestions }" class="form-control col-sm-12" placeholder="Question ${this.countQuestions}">
						<input type="hidden" name="correctCount" value="">
					</div>
				`;

				for ( let i = 1; i <= this.countAnswers; i++ ){
					let questionChar = String.fromCharCode(i + 64);
					item.innerHTML += `
						<div class="col-sm-6">
							  <div class="input-group-prepend">
									<div class="input-group-text">
									  	<input type="checkbox" aria-label="Checkbox for following text input" name="${ 'correct'+this.countQuestions+i }">
									</div>
									<input type="text" name="${ 'answer'+this.countQuestions+i }" class="form-control" placeholder="Answer ${ questionChar }" required>
							  </div>
						</div>
					`;
				}

				wrap.appendChild(item);
				wrapper.appendChild(wrap);
				++this.countQuestions;
			},

		}
	}
</script>

<style scoped>
</style>
function convertToJson(nodelist){
	let obj = [];
	for(let node of nodelist){
		obj.push({
			'student_id': node.name,
			'is_present': node.checked,
			'date': new Date().toISOString().split('T')[0] // Format YYYY-mm-dd
		});
	}
	return obj;
}

let presence_btn = document.getElementById('presence');
let token = document.querySelector("meta[name='csrf-token']").getAttribute('content');
let toast = document.getElementById('request-toast');
let toast_text = document.getElementById('request-text');

window.addEventListener('click', function(ev){
	toast.classList.add('hidden');
});

presence_btn.addEventListener('click', function(ev){
	let checkboxes = document.querySelectorAll("input[type='checkbox']");
	checkboxes = convertToJson(checkboxes);
	fetch('/presence/take', {
		method: 'POST',
		headers: {'X-CSRF-TOKEN': token},
		body: JSON.stringify(checkboxes)
	}).then(res => {
		return res.text();
	}).then(text => {
		toast.classList.remove('hidden');
		toast_text.innerText = text;
	});
});

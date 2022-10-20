let token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");
let toast = document.getElementById("request-toast");
let toast_text = document.getElementById("request-text");
window.addEventListener("click", function (ev) {
    toast.classList.add("hidden");
});

function insertStudent(element) {
    const errorText = document.querySelectorAll("span.error-text");

    errorText.forEach((el) => {
        el.innerHTML = "";
    });

    let parentElement = element.parentElement;
    let name = document.querySelector("#name-insert");
    let surname = document.querySelector("#surname-insert");
    let data = {
        name: name.value,
        surname: surname.value,
    };
    fetch("/students/add", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": token },
        body: JSON.stringify(data),
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            switch(data.status.toLowerCase()){
                case 'success':
                    addStudentInTable(data.body.student);
                    toast_text.innerHTML = data.message;
                    toast.classList.remove("hidden");
                    toggleModal();
                    break;
                case 'failure':
                    displayErrors(data.errors);
                    break;
            }
        })
        .catch(function (error) {
            console.log(error);
        });

}

function deleteStudent(element) {
    fetch("/students/delete", {
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": token },
        body: JSON.stringify({"id": element.dataset.id}),
    }).then((res) => {
        return res.json();
    }).then((data) => {
        switch(data.status.toLowerCase()){
            case 'success':
                element.parentElement.parentElement.remove();
                toast.classList.remove("hidden");
                toast_text.innerText = data.message;
                break;
            case 'failure':
                console.log(data.errors)
                break;
        }
    })
    .catch((error) => {
        console.log("error");
    });
}

function displayErrors(data) {
    for (var key in data) {
        document.querySelector("span." + key + "_error").innerHTML = data[key];
    }
}

function addStudentInTable(student) {
    let table = document.getElementById("student-table");
    let row = table.insertRow(-1);
    row.classList = " bg-white border-b dark:bg-gray-800 dark:border-gray-700 ";

    let cell1 = row.insertCell(0)
    let cell2 = row.insertCell(1)
    let cell3 = row.insertCell(2)
    let cellDelete = row.insertCell(3)
    setCellsAttributes([cell1, cell2, cell3])

    setAttributes(cellDelete,{
        scope: "row",
        class: "py-4 px-0 font-medium text-gray-900 whitespace-nowrap dark:text-white"
    })

    cell1.innerHTML = student['id']
    cell2.innerHTML = student['name']
    cell3.innerHTML = student['surname']
    cellDelete.innerHTML = `<button data-id="${student.id}" onclick="deleteStudent(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-0.5 px-3 rounded-full content-center">Delete</button>`;
}


function setCellsAttributes(cells){
    for(let cell of cells){
        setAttributes(cell, {
            scope: "row",
            class: "py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white",
        });
    }
}

function setAttributes(el, attrs) {
    for (var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
}

function toggleModal() {
    document.getElementById('modal').classList.toggle('hidden')
  }

const tagList = document.querySelector("#tagsList");

function createTag() {
  const inputField = document.getElementById('tagInput');
  const tag = document.createElement("li");
  tag.className = "tag";
  const text = inputField.value.trim().toLowerCase();
  
  if (text !== '' && !document.getElementById(text)) {
    const tagText = document.createElement("span");
    tagText.textContent = text;
    tagText.className = 'tagText';
    tag.id = text; 
    
    const removeButton = document.createElement("span");
    removeButton.className = "remove";
    removeButton.textContent = 'X';
    removeButton.addEventListener(
      "click",
      () => {
        removeTag(tag); 
      },
      { once: true }
    );
    tag.appendChild(tagText);
    tag.appendChild(removeButton);
    tagList.appendChild(tag);  
  }
  inputField.value = ''; 
};

function removeTag(tagToRemove){
  if (tagToRemove) {
    tagToRemove.remove();
  }
};


/*  
const form = document.getElementById('newsForm');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    const tagsInput = document.createElement("input");
    tagsInput.type = "hidden";
    tagsInput.name = "tags"; 
  
    let tagsList = document.getElementById('tagsList');
    let liElements = tagsList.getElementsByClassName('tagText');
    let tagArray = [];
    for (var i = 0; i < liElements.length; i++) {
      tagArray.push(liElements[i].textContent);
    }

    tagsInput.value = JSON.stringify(tagArray);

    form.appendChild(tagsInput);

    form.submit()

  });

*/
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsForm');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const tagsInput = document.createElement("input");
        tagsInput.type = "hidden";
        tagsInput.name = "tags";

        const tagsList = document.getElementById('tagsList');
        const liElements = tagsList.getElementsByClassName('tagText');
        const tagArray = Array.from(liElements).map(li => li.textContent);

        tagsInput.value = JSON.stringify(tagArray);

        form.appendChild(tagsInput);

        // Prevent double submission if the input is successfully added
        if (!form.submitted) {
            form.submitted = true; // Mark the form as submitted
            form.submit();
        }
    });
});

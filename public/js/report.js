document.querySelectorAll('.action_report').forEach(button => {
    button.addEventListener('click', event => {
        let action = event.target.dataset.operation;
        let method, request;
        if(action == 'delete_user'){
            request = event.target.parentNode.parentNode.querySelector('h4').id;
            method = 'DELETE';
        }
        if(action == 'delete_report'){
            request = event.target.parentNode.parentNode.id;
            method = 'DELETE';
        }
        if(action == 'block_user') {
            request = event.target.parentNode.parentNode.querySelector('h4').id;
            method = 'POST';
        }
        console.log(method);
        console.log(request);
        sendAjaxRequest(
            `${method}`,
            `/api/${action}`,
            {request},
            reportHandler
      );
    })
  })

function reportHandler() {
    //if (this.status != 200) window.location = '/';
    const action = JSON.parse(this.responseText).action;
    if(action == 'delete_user'){
        let selector = 'article h4[id="' + JSON.parse(this.responseText).user + '"]';        
        let elements = document.querySelectorAll(selector);
        elements.forEach(function(element) {
            element.parentNode.remove();
        });
    }
    if(action == "delete_report") {
        let selector = 'article[id="' + JSON.parse(this.responseText).report + '"]';        
        let element = document.querySelector(selector);
        element.remove();
    }
    if(action == "block_user") {
        let selector = 'article h4[id="' + JSON.parse(this.responseText).user + '"]';        
        let elements = document.querySelectorAll(selector);
        elements.forEach(function(element) {
            element.textContent += "(this user is blocked)";
            element.parentNode.querySelector("[data-operation=block_user]").remove();
        });
    }
    let mainElement = document.querySelector('#list_reports');
    if(mainElement.children.length <= 1) { //por causa do span da listagem
        mainElement.textContent = 'There are no reports to show.';
    }
}
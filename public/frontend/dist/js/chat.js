const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");
message = document.getElementById("monmessage").val;

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

//sendBtn.onclick = ()=>{
    /*alert(message);
    $.ajax({
        url: '/messagerie/inserer_message',
        type: 'POST',
        data:{
            "message": message,
            "incoming_id": incoming_id,
            "_token": "{{ csrf_token() }}",
             },
        success: function(data){
            inputField.value = "";
            scrollToBottom();
        }
    });

    /*$.ajax({
        url: '/messagerie/inserer_message/'+incoming_id+'/'+message,
        type: 'GET',
        data:{
            "message": message,
            "incoming_id": incoming_id,
            "_token": "{{ csrf_token() }}",
             },
        success: function(data){
            inputField.value = "";
            scrollToBottom();
        }
    });
    */
    /*let xhr = new XMLHttpRequest();
    xhr.open("POST", "/messagerie/inserer_chat", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);*/
//}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}
/*
setInterval(() =>{
    let xhr = new XMLHttpRequest();
    var csrfToken = "{{ csrf_token() }}";

    xhr.open("POST", "/messagerie/get_chat", true);
    

    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{csrf_token()}}');
    //xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send("incoming_id="+incoming_id);
}, 500);
*/
      
setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/messagerie/get_chat/"+incoming_id, true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);


function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
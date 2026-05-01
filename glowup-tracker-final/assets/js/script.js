function confirmDelete(){
  return confirm('Are you sure you want to delete this task?');
}

function toggleDark(){
  document.body.classList.toggle('dark');
}

function openEdit(id,title,desc,date){
  document.getElementById('modal').style.display='block';
  document.getElementById('edit-id').value=id;
  document.getElementById('edit-title').value=title;
  document.getElementById('edit-desc').value=desc;
  document.getElementById('edit-date').value=date;
}

function closeModal(){
  document.getElementById('modal').style.display='none';
}

function validateTask(form){
  if(form.title.value.trim()===''){
    alert('Title required');
    return false;
  }
  return true;
}

function validateAuth(form){
  let ok=true;
  form.querySelectorAll('input').forEach(i=>{
    if(!i.value.trim()){
      i.style.border='2px solid red';
      ok=false;
    } else i.style.border='1px solid #ccc';
  });
  return ok;
}

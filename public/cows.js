function delete_cow(id, cow_id) {
  console.log(cow_id);
  document.getElementById("del_id").value = id;
  document.getElementById("label_id").innerHTML =
    `Czy napewno chesz usunąć krowę o numerze <strong>${cow_id}</strong>?`;
  const dialog = document.getElementById("del_dialog");
  dialog.showModal();
}

function close_dialog() {
  const dialog = document.getElementById("del_dialog");
  dialog.close();
}

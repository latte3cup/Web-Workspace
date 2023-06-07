function searchRecipe() {
    
  // 텍스트박스의 값을 가져옴
  var searchValue = document.getElementById('searchInput').value;

  if (searchValue.trim() !== '') {
  window.location.href = "search.php?query=" + encodeURIComponent(searchValue);
  } else {
  alert('검색어를 입력해 주세요');
  }
  
}

function searchEnter(event){
  if(event.keyCode===13){
      searchRecipe();
  }
  
}

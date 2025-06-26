const openBtn = document.getElementById('openFormBtn');
const closeBtn = document.getElementById('closeFormBtn');
const modal = document.getElementById('formModal');
const userKeyInput = document.getElementById('user_key'); 
    

    openBtn.addEventListener('click', () => {
    const inputKey = prompt("ユーザーキーを入力してください：");
    if (inputKey && inputKey.trim() !== "") {
        userKeyInput.value = inputKey.trim(); // 入力されたキーをフォームに渡す
        // userKeyInput.value = inputKey; // フォームに埋め込み
        modal.style.display = 'flex';
      } else {
        alert("ユーザーキーが間違っています");
      }
    });
    
    

    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });


    // 曲データを読み込んで表示
fetch('data/songs.json')
.then(response => response.json())
.then(songs => {
  const container = document.getElementById('song-container');
  songs.forEach(song => {
    const card = document.createElement('div');
    card.classList.add('song-card');

    card.innerHTML = `
      <img src="${song.image}" alt="${song.title}" class="cover">
      <div class="info">
        <h3>${song.title}</h3>
        <p>${song.artist}</p>
        <p>${song.genre} / ${song.bpm} BPM / ${song.key}</p>
        <audio controls controlsList="nodownload" oncontextmenu="return false;" src="${song.audio}"></audio>
      </div>
    `;

    container.appendChild(card);
  });
})
.catch(error => {
  console.error("データの読み込みに失敗しました:", error);
});

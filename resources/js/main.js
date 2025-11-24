document.addEventListener("DOMContentLoaded", () => {
  const targetBtn = document.getElementById("regist-btn");
  const consentBox = document.querySelector("input[name='consent']");

  if (!targetBtn || !consentBox) return;

  targetBtn.disabled = true;
  targetBtn.classList.add("is-inactive");

  consentBox.addEventListener("change", (e) => {
    const isChecked = e.target.checked;

    targetBtn.disabled = !isChecked;
    targetBtn.classList.toggle("is-active", isChecked);
    targetBtn.classList.toggle("is-inactive", !isChecked);
  });
});

document.addEventListener('DOMContentLoaded', () => {
  //レンタルクラブのモデル自動表示
  const clubSelect = document.querySelector("#club-select");
  const modelDisplay = document.querySelector("#model-display");

  const updateModelDisplay = () => {
    const selectedOption = clubSelect.options[clubSelect.selectedIndex];
    modelDisplay.textContent = selectedOption.dataset.model;
  };

  if (clubSelect && modelDisplay) {
    updateModelDisplay();
    clubSelect.addEventListener("change", updateModelDisplay);
  }

  //レンタルクラブ・シャワーのチェックを外すとデフォルト表示へ切替
  const checkRental = document.getElementById('rental');
  if(checkRental && checkRental.checked) {
    const selectClub = document.getElementById('club-select');
    checkRental.addEventListener('change', function() {
      selectClub.selectedIndex = 0;
      updateModelDisplay();
    })
  }
  const checkShower = document.getElementById('shower');
  if(checkShower && checkShower.checked) {
    const selectShowerTime = document.getElementById('shower-time');
    checkShower.addEventListener('change', function() {
      selectShowerTime.selectedIndex = 0;
    })
  }
})

//料金計算
const feeArray = document.querySelectorAll(".fee");
const total = document.getElementById("total-fee");
let totalFee = 0;
if (feeArray && total) {
  feeArray.forEach((eachFee) => {
    totalFee += parseInt(eachFee.dataset.fee);
  });
  total.innerHTML = totalFee.toLocaleString() + "円";
}

//セッション破棄の導線
const hasSessionBtn = document.querySelectorAll('.has-session');

if(hasSessionBtn) {
  hasSessionBtn.forEach((btn) => {
    btn.addEventListener('click', function() {
      if(confirm('登録内容を破棄しますが宜しいですか？')) {
        document.getElementById('route-input').value = btn.getAttribute('data-route');
        document.getElementById('session-form').submit();
      }
    })
  })
}

//ログアウト
const logout = document.getElementById('logout');
if(logout) {
  logout.addEventListener('click', () => {
    if(confirm('ログアウトしますか？')) {
      document.getElementById('submit-form').submit();
    }
  })
}


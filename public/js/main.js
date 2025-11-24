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

//レンタルクラブのモデル自動表示
document.addEventListener("DOMContentLoaded", () => {
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
});

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

// ナビゲーションメニューの切替(確認画面から別画面移動時)
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".with-confirm").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const url = this.dataset.href;
      if (confirm("登録内容を破棄しますがよろしいですか？")) {
        window.location.href = "/my_golf_range/session_destroy?redirect=" + encodeURIComponent(url);
      }
    });
  });
});

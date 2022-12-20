// 定義
// ------------------
const weeks = ["日", "月", "火", "水", "木", "金", "土"];
let date = new Date();
let year = date.getFullYear();
let month = date.getMonth() + 1;
let day = date.getDay();
const today = year + "-" + month.toString().padStart(2, "0") + "-" + day.toString().padStart(2, "0");

// 関数
// ------------------

// 枠をつくる
function get_product_list(date) {
	const searchDate = date;
	const url = "./sales_performance_get_product_list_ajax.php";
	axios
		.get(`${url}?search_date=${searchDate}`)
		.then(function (response) {
			console.log(response.data);
			htmlElement = "";
			response.data.forEach((record) => {
				htmlElement += `
          <tr>
            <td>${record.product_name}</td>
            <td>
              <input type="text" id="${record.id}" name='quantity'>
              </td>
            <td>${record.unit}</td>
          </tr>
        `;
			});
			$("tbody").html(htmlElement);
		})
		.catch(function (error) {})
		.finally(function () {});
}

// データを登録する
function post_quantity(product_id, quantity, date) {
	const url = "./quantity_add_act_ajax.php";
	axios
		.get(`${url}?product_id=${product_id}&quantity=${quantity}&date=${date}`)
		.then(function (response) {
			console.log(response);
		})
		.catch(function (error) {})
		.finally(function () {});
}

// 実行
// ------------------
// 表の日付を入力
$("#select_date").val(today);
get_product_list(today);

// 監視
// ------------------
// 日付変更したとき
$("#select_date").on("change", function (e) {
	get_product_list(e.target.value);
});

// 数量を入力したとき
$("body").on("blur", "input", function (e) {
	post_quantity(e.target.id, e.target.value, $("#select_date").val());
});

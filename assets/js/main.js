// const URL = window.location.href;

const URL = 'https://todo.nctu.edu.vn';

// Socket.io Notification
// document.addEventListener("DOMContentLoaded", function () {
//   const userId = $(".notifications-list").data("user-id");

//   const socket = io("ws://localhost:3000");

//   console.log(userId);

//   socket.on(`fetchNotifications_${userId}`, function (message) {
//     console.log(message);

//     if (message) {
//       $("#notifications-alert").attr("style", "display: block");

//       let html = "";

//       html += '<li class="notification-item"></li>' + message + "</li>";

//       $(".notifications-list").html(html);
//     } else {
//       $("#notifications-alert").attr("style", "display: none");
//     }
//   });
// });

// Handle project title change
$(".project-title").change(function () {
  const id = $(this).attr("data-project-id");
  const title = $(this).val().trim("");

  $.ajax({
    url: `${baseUrl}admin/items/update/${id}`,
    method: "post",
    dataType: "json",
    data: {
      title,
    },
    success: function (response) {
      if (response.success) {
        toastr.success("Cập nhật tiêu đề thành công!");
        $(`.project_title[data-project-id='${id}']`).find("span").text(title);
      }
    },
  });
});

//Handle project scope
$(".project-scope").change(function () {
  const id = $(this).attr("data-project-id");
  var is_private = $(this).is(":checked") ? 1 : 0;
  const listItem = $(`li[data-project-id='${id}']`).closest(
    ".list-project-item"
  );

  $.ajax({
    url: `${baseUrl}admin/items/update/${id}`,
    method: "post",
    dataType: "json",
    data: {
      is_private,
    },
    success: function (response) {
      if (response.success) {
        toastr.success("Cập nhật phạm vi của bảng thành công!");
        if (is_private === 1) {
          listItem.attr("hidden", true);
        } else {
          listItem.attr("hidden", false);
        }
      }
    },
  });
});

// Handle clear file
$(document).on("click", ".btn-clear-file", function () {
  const file_id = $(this).attr("data-file-id");
  const group_id = $(this).attr("data-group-id");
  const project_id = $(this).attr("data-project-id");

  let meta_id = $(this).attr("data-meta-id");

  const payload = {
    meta_id: meta_id,
    file_id,
    project_id,
    group_id,
  };

  $.ajax({
    url: `${baseUrl}file/update_meta`,
    method: "post",
    data: payload,
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $(`.file_meta_input[data-meta-id='${meta_id}']`).html(
          response?.file_html
        );

        $(`.file_list_item[data-file-id='${file_id}']`).remove();

        toastr.success("Tệp tin đã được gở bỏ!");
      }
    },
  });
});

// Handle preview image in modal
$("body").on("click", ".file-image", function () {
  const file_id = $(this).attr("data-file-id");

  const file_info = $(this).find(".file-info");

  const title = file_info.attr("data-file-title");
  const desc = file_info.attr("data-file-desc");
  let path = file_info.attr("data-file-path");
  const type = file_info.attr("data-file-type");
  const created_at = file_info.attr("data-file-upload-date");

  $(".file_info_description").attr("data-file-id", file_id);
  $(".file_info_name").attr("data-file-id", file_id);
  $(".file-name").text(title);
  $(".file_info_description").val(desc);
  $(".file_info_name").val(title);
  $(".file_info_upload_date").text(created_at);

  if ("pdf|doc|docx|xls|xlsx|ppt|pptx|rar|zip".split("|").includes(type)) {
    $(".file_info_type").text(type);
    $(".image-preview").attr("src", `${baseUrl}assets/images/${type}.svg`);
  } else {
    $(".file_info_type").text("image");
    $(".image-preview").attr("src", path);
  }

  $(".btn-download-file-modal").attr("data-path", path.replace("enc", type));
  $(".btn-download-file-modal").attr("data-file-title", title);
  $(".btn-download-file-modal").attr("data-file-type", type);
  $(".btn-download-file-modal").attr("data-file-path", path);

  $("#imageModal").modal("show");
});

$(".btn-download-file-modal").click(function (e) {
  const title = $(this).attr("data-file-title");
  const type = $(this).attr("data-file-type");
  const path = $(this).attr("data-file-path");
  const file_name = title.replace("." + type, "") + "." + type;

  console.log(file_name);

  const link = document.createElement("a");
  document.body.appendChild(link);
  link.setAttribute("download", file_name);
  link.href = path;
  link.click();
  link.remove();
  e.stopPropagation();
});

// Handle file desc change
$("body").on("change", ".file_info_description", function () {
  const desc = $(this).val();
  const file_id = $(this).attr("data-file-id");

  $.ajax({
    url: `${baseUrl}file/update/${file_id}`,
    method: "post",
    data: { desc },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $(`.file-desc[data-file-id='${file_id}']`).text(
          response?.data?.description
        );

        toastr.success("Cập nhật dữ liệu thành công!");
      }
    },
  });
});

// Handle file title change
$("body").on("change", ".file_info_name", function () {
  const title = $(this).val();
  const file_id = $(this).attr("data-file-id");

  $.ajax({
    url: `${baseUrl}file/update/${file_id}`,
    method: "post",
    data: { title },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $(`.file-title[data-file-id='${file_id}']`).text(response?.data?.title);
        toastr.success("Cập nhật dữ liệu thành công!");
      }
    },
  });
});

const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

let table = new DataTable("#dataTable");

// Handle Update icon collapse
$("body").on("click", ".btn-collapse", function () {
  const isCollapsed = $(this).hasClass("collapsed");

  if (isCollapsed) {
    $(this).children().attr("class", "fa fa-chevron-right text-primary");
  } else {
    $(this).children().attr("class", "fa fa-chevron-down text-primary");
  }
});

//Collapse sidebar
function setSidebarState(collapsed) {
  if (collapsed) {
    $("#side-bar").addClass("sidebar_home").removeClass("col-md-4 col-lg-3 col-xxl-2");
    $("#sidebar_left").addClass("col-12").removeClass("col-2");
    $("#sidebar_right").attr("hidden", true);
  } else {
    $("#side-bar").addClass("col-md-4 col-lg-3 col-xxl-2").removeClass("sidebar_home");
    $("#sidebar_left").addClass("col-2").removeClass("col-12");
    $("#sidebar_right").removeAttr("hidden");
  }
}

//Sidebar state when reload page
function initSidebarState() {
  const collapsed = localStorage.getItem("sidebar_collapsed") === "true";
  $("#sidebar_right").toggleClass("collapsed", collapsed);
  $("#main-content").toggleClass("expanded", collapsed);
  setSidebarState(collapsed);
}

$(document).ready(function () {
  const currentURL = window.location.href;
  if (currentURL.match(baseUrl + "folder/view/\\d+") || currentURL.match(baseUrl + "table/view/\\d+" ) || currentURL.match(baseUrl + "customtable/view/\\d+" )){ //chỉ collapse khi trong view folder
    initSidebarState();

    $("#toggle-sidebar").on("click", function () {
        $("#sidebar_right").toggleClass("collapsed");
        $("#main-content").toggleClass("expanded");

        const collapsed = $("#sidebar_right").hasClass("collapsed");
        setSidebarState(collapsed);

        // Save the sidebar state to localStorage
        localStorage.setItem('sidebar_collapsed', collapsed);
    });
}
});

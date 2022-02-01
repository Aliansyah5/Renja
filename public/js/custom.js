const optionSelect2 = {
    placeholder: "Pilih...",
    theme: "bootstrap4",
};
function formatRupiah(angka, decimal = 2, prefix = "IDR") {
    var minus = false;
    if (angka < 0) {
        minus = true;
    }
    angka = parseFloat(angka);
    var strAngka = angka
        .toFixed(decimal)
        .toString()
        // Keep only digits and decimal points:
        .replace(/[^\d.]/g, "")
        // Remove duplicated decimal point, if one exists:
        .replace(/^(\d*\.)(.*)\.(.*)$/, "$1$2$3")
        // Keep only two digits past the decimal point:
        .replace(/\.(\d{2})\d+/, ".$1")
        // Add thousands separators:
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    if (minus) {
        strAngka = "-" + strAngka;
    }

    return strAngka;
}

function cleanNumber(value) {
    return value.replace(/[^,\d]/g, "");
}

function isLater(dateString1, dateString2) {
    return dateString1 > dateString2;
}

function processToDate(date) {
    var parts = date.split("/");
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function redirect(url) {
    window.location.href = url;
}

function deleteData(dt) {
    if (confirm("Are you sure you want to delete this data?")) {
        $.ajax({
            type: "POST",
            url: $(dt).data("url"),
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: "delete",
            },
            success: function (response) {
                if (response.status) {
                    location.reload();
                }
            },
            error: function (response) {
                console.log(response);
            },
        });
    }
    return false;
}

function processExcel(data) {
    var workbook = XLSX.read(data, {
        type: "binary",
    });

    var firstSheet = workbook.SheetNames[0];
    var data = to_json(workbook);
    return data;
}

function to_json(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function (sheetName) {
        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
            header: 1,
        });
        if (roa.length) result[sheetName] = roa;
    });
    return JSON.stringify(result, 2, 2);
}

function simpleArray(objContent) {
    var key = objContent[0];
    var data = objContent;
    data.splice(0, 1);
    var newData = [];
    $.each(data, function (index, value) {
        var tempdata = [];
        $.each(value, function (index2, value2) {
            // console.log(key[index2]);
            tempdata[key[index2]] = value2;
        });
        newData[index] = tempdata;
    });
    return newData;
}

function simpleArray2(objContent) {
    var key = objContent[0];
    var data = objContent;
    data.splice(0, 1);
    var newData = [];
    $.each(data, function (index, value) {
        var tempdata = [];
        $.each(value, function (index2, value2) {
            // console.log(key[index2]);
            tempdata[key[index2]] = value2;
        });
        newData[index] = tempdata;
    });
    return newData;
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function ColorToRGB(rgb) {
    var r = rgb & 0xff;
    var g = (rgb >> 8) & 0xff;
    var b = (rgb >> 16) & 0xff;

    return {
        r: r,
        g: g,
        b: b,
    };
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result
        ? {
              r: parseInt(result[1], 16),
              g: parseInt(result[2], 16),
              b: parseInt(result[3], 16),
          }
        : null;
}

function extractOnlyText(txt) {
    var answer = txt;
    if (answer) {
        answer = answer.replace(/[^A-Za-z]/g, "");
        return answer;
    } else {
        return "";
    }
}

$(".select2-custom").select2({
    tags: true,
    createTag: function (term) {
        return { id: term, text: term };
    },
});

function extractOnlyNumber(txt) {
    if (txt) {
        var numb = txt.match(/\d/g);
        if (numb) {
            numb = numb.join("");
            return numb;
        } else {
            return "";
        }
    } else {
        return "";
    }
}

$(document.body).on("click", ".btnDeleteDetail", function (e) {
    e.preventDefault();
    var objListRow = $("#tableBody").find("tr");
    var isdelete = objListRow.attr("deleted");
    console.log(typeof isdelete);
    if (typeof isdelete == "undefined") {
        if (objListRow.length == 1 && !objListRow.attr("deleted")) {
            toastr.error("Anda tidak dapat menghapus data pertama");
            return;
        }
    }
    var objRow = $(this).parent().parent();
    Swal.fire({
        title: "Anda yakin ingin menghapus data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
    }).then((result) => {
        if (result.value) {
            var html =
                "<input type='hidden' name='detaildeleted[]' value='" +
                objRow.find(".data_id").val() +
                "'>";
            $("#deleteContainer").append(html);
            objRow.remove();
        }
    });
});

function blockMessage(element, message, color) {
    jQuery(element).block({
        message:
            '<span class="text-semibold"><i class="icon-spinner4 spinner position-left"></i>&nbsp; ' +
            message +
            "</span>",
        overlayCSS: {
            backgroundColor: color,
            opacity: 0.8,
            cursor: "wait",
        },
        css: {
            border: 0,
            padding: "10px 15px",
            color: "#fff",
            width: "auto",
            "-webkit-border-radius": 2,
            "-moz-border-radius": 2,
            backgroundColor: "#333",
        },
    });
}

//fixed header
$(".freezetable").on("scroll", function () {
    // $(".freezetable > *").width($(".freezetable").width() + $(".freezetable").scrollLeft());
});

// New JavaScript

var $stickyHeader = $(".freezetable tbody tr th");
var $stickyHeadest = $(".freezetable thead tr td");
var $stickyCells = $(".freezetable tbody tr td:first-child");

$(".freezetable").on("scroll", function () {
    console.log("grinding");
    // $stickyHeader.css('position', 'relative');
    $stickyHeadest.css("top", $(this).scrollTop() + "px");
    $stickyHeader.css("top", $(this).scrollTop() + "px");
    $stickyCells.css("left", $(this).scrollLeft() + "px");
});

$(".sticky-table").on("scroll", function () {
    var $stickyTop1 = $(".sticky-table thead tr th");
    var $stickyTop2 = $(".sticky-table tbody tr td");
    var $stickyCellKode = $(".sticky-table tbody tr td:nth-child(3)");
    var $stickyCellGrup = $(".sticky-table tbody tr td:nth-child(2)");
    var $stickyCellNo = $(".sticky-table tbody tr td:nth-child(1)");

    // $stickyTop1.css('position', 'relative');
    $stickyTop1.css("top", $(this).scrollTop() + "px");
    $stickyTop1.css("scroll-behavior", "smooth");

    $stickyCellKode.css("left", $(this).scrollLeft() + "px");
    $stickyCellGrup.css("left", $(this).scrollLeft() + "px");
    $stickyCellNo.css("left", $(this).scrollLeft() + "px");
});

$(".sticky-table-pe").on("scroll", function () {
    var $stickyTop1 = $(".sticky-table-pe thead tr th");
    var $stickyTop2 = $(".sticky-table-pe tbody tr td");
    var $stickyCellKode = $(".sticky-table-pe tbody tr td:nth-child(3)");
    var $stickyCellGrup = $(".sticky-table-pe tbody tr td:nth-child(2)");

    // $stickyTop1.css('position', 'relative');
    $stickyTop1.css("top", $(this).scrollTop() + "px");
    $stickyTop1.css("scroll-behavior", "smooth");

    $stickyCellKode.css("left", $(this).scrollLeft() + "px");
    $stickyCellGrup.css("left", $(this).scrollLeft() + "px");
});

$(".sticky-percobaan").on("scroll", function () {
    var $stickyTop1 = $(".sticky-percobaan thead tr th");
    var $stickyCellNo = $(".sticky-percobaan tbody tr td:nth-child(1)");

    $stickyTop1.css("top", $(this).scrollTop() + "px");
    $stickyTop1.css("scroll-behavior", "smooth");

    $stickyCellNo.css("background-color", "#EFEFEF");
    $stickyCellNo.css("left", $(this).scrollLeft() + "px");
});

$(".select2").select2({
    placeholder: "Pilih...",
    theme: "bootstrap4",
});

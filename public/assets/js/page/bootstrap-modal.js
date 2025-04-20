"use strict";

$("#modal-1").fireModal({ body: "Modal body text goes here." });

function handleFileInput(inputId, previewId) {
    document
        .getElementById(inputId)
        .addEventListener("change", function (event) {
            let previewContainer = document.getElementById(previewId);
            previewContainer.innerHTML = "";

            let file = event.target.files[0];
            if (!file) return;

            if (file.type === "application/pdf") {
                let img = document.createElement("img");
                img.src =
                    "https://cdn-icons-png.flaticon.com/512/337/337946.png"; // Icon PDF
                img.className = "pdf-icon";

                let fileName = document.createElement("span");
                fileName.textContent = file.name;

                previewContainer.appendChild(img);
                previewContainer.appendChild(fileName);
            } else {
                previewContainer.innerHTML =
                    "<p class='text-danger'>Hanya file PDF yang diizinkan!</p>";
                this.value = ""; // Reset input jika bukan PDF
            }
        });
}
$(document).ready(function () {
    $(document)
        .off("click", ".editBtn")
        .on("click", ".editBtn", function () {
            let id = $(this).data("id");

            $.ajax({
                url: "/arsip-pensiun/edit/" + id,
                type: "GET",
                success: function (response) {
                    // Pastikan modal tidak double
                    $("#dummy-modal-btn").remove();
                    $(".modal").modal("hide");

                    // Buat select option unit kerja
                    let unitOptions = "";
                    response.unitKerja.id.forEach(function (unitId, index) {
                        let selected =
                            unitId == response.unit_kerja ? "selected" : "";
                        unitOptions += `<option value="${unitId}" ${selected}>${response.unitKerja.unit_kerja[index]}</option>`;
                    });

                    // Dummy button untuk trigger modal
                    let dummyBtn = $(
                        '<button id="dummy-modal-btn" style="display:none;"></button>'
                    );
                    $("body").append(dummyBtn);

                    // Fire Modal
                    $("#dummy-modal-btn").fireModal({
                        title: "Edit Arsip Pensiun",
                        body: `
                        <form id="edit-form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="${$(
                                'meta[name="csrf-token"]'
                            ).attr("content")}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id_edit" value="${
                                response.id
                            }">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="${
                                    response.nama
                                }">
                            </div>

                            <div class="form-group">
                                <label>Nomor SK</label>
                                <input type="text" class="form-control" name="nomor_sk" value="${
                                    response.nomor_sk
                                }">
                            </div>

                            <div class="form-group">
                                <label>Unit Kerja</label>
                                <select class="form-control" name="unit_kerja">
                                    ${unitOptions}
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Surat</label>
                                <input type="date" class="form-control" name="tanggal_surat" value="${
                                    response.tanggal_surat
                                }">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Diterima</label>
                                <input type="date" class="form-control" name="tanggal_diterima" value="${
                                    response.tanggal_diterima
                                }">
                            </div>

                            <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-gap-4">
                        <!-- Dokumen 1 -->
<div class="form-group md:tw-w-1/2 tw-mb-4">
    <label class="tw-block tw-mb-2 tw-font-semibold">Upload Dokumen 1 (PDF)</label>
    <label class="custom-file-upload">
        <input type="file" id="dokumen1" name="dokumen1" accept="application/pdf">
        Pilih Dokumen 1
    </label>
    <div id="preview-dokumen1" class="preview-container"></div>
    <small class="form-text text-muted">
        File sebelumnya: ${
            response.dokumen1
                ? `<a href="${response.dokumen1}" target="_blank"><i class="fa fa-download"></i> Lihat File</a>`
                : "Belum ada file"
        }
    </small>
</div>

                        <!-- Dokumen 2 -->
                       <div class="form-group md:tw-w-1/2 tw-mb-4">
    <label class="tw-block tw-mb-2 tw-font-semibold">Upload Dokumen 2 (PDF)</label>
    <label class="custom-file-upload">
        <input type="file" id="dokumen2" name="dokumen2" accept="application/pdf">
        Pilih Dokumen 2
    </label>
    <div id="preview-dokumen2" class="preview-container"></div>
    <small class="form-text text-muted">
        File sebelumnya: ${
            response.dokumen2
                ? `<a href="${response.dokumen2}" target="_blank"><i class="fa fa-download"></i> Lihat File</a>`
                : "Belum ada file"
        }
    </small>
</div>

                    </div>


                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        `,
                        center: true,
                        buttons: [
                            {
                                text: "Batal",
                                class: "btn btn-danger",
                                handler: function (modal) {
                                    modal.modal("hide");
                                },
                            },
                        ],
                    });

                    // Trigger modal
                    $("#dummy-modal-btn").click();

                    handleFileInput("dokumen1", "preview-dokumen1");
                    handleFileInput("dokumen2", "preview-dokumen2");
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire("Error", "Data tidak ditemukan!", "error");
                },
            });
        });

    $(document)
        .off("submit", "#edit-form")
        .on("submit", "#edit-form", function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(this);
            let id = form.find('input[name="id_edit"]').val();

            console.log("Form disubmit!");

            // Reset error
            form.find(".is-invalid").removeClass("is-invalid");
            form.find(".invalid-feedback").remove();

            let submitBtn = form.find('button[type="submit"]');
            submitBtn.prop("disabled", true);

            $.ajax({
                url: "/arsip-pensiun/update/" + id,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    submitBtn.prop("disabled", false).text("Simpan");
                    Swal.fire({
                        icon: "success",
                        title: "Sukses!",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    $(".modal").modal("hide");
                    $("#arsipTable").DataTable().ajax.reload(null, false);
                },
                error: function (err) {
                    console.log(err.responseText);
                    // Tombol submit diaktifkan lagi, entah sukses atau error
                    let submitBtn = form.find('button[type="submit"]');
                    submitBtn.prop("disabled", false).text("Simpan");

                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menyimpan data.",
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        $.each(errors, function (field, messages) {
                            let input = form.find('[name="' + field + '"]');
                            input.addClass("is-invalid");

                            if (input.attr("type") === "file") {
                                // Cari parent form-group supaya pesan error kelihatan
                                let container = input.closest(".form-group");
                                container.find(".invalid-feedback").remove(); // bersihkan dulu
                                container.append(
                                    '<div class="invalid-feedback d-block">' +
                                        messages.join("<br>") +
                                        "</div>"
                                );
                            } else {
                                input.after(
                                    '<div class="invalid-feedback">' +
                                        messages.join("<br>") +
                                        "</div>"
                                );
                            }
                        });
                        $(".modal").removeClass("modal-progress");
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan saat menyimpan data.",
                        });
                    }
                },
            });
        });
    // Unbind dulu biar gak dobel listener
    $(document).on("hidden.bs.modal", ".modal", function () {
        $(this).find("#edit-form").remove();
    });
});

let modal_3_body =
    '<p>Object to create a button on the modal.</p><pre class="language-javascript"><code>';
modal_3_body += "[\n";
modal_3_body += " {\n";
modal_3_body += "   text: 'Login',\n";
modal_3_body += "   submit: true,\n";
modal_3_body += "   class: 'btn btn-primary btn-shadow',\n";
modal_3_body += "   handler: function(modal) {\n";
modal_3_body += "     alert('Hello, you clicked me!');\n";
modal_3_body += "   }\n";
modal_3_body += " }\n";
modal_3_body += "]";
modal_3_body += "</code></pre>";
$("#modal-3").fireModal({
    title: "Modal with Buttons",
    body: modal_3_body,
    buttons: [
        {
            text: "Click, me!",
            class: "btn btn-primary btn-shadow",
            handler: function (modal) {
                alert("Hello, you clicked me!");
            },
        },
    ],
});

$("#modal-4").fireModal({
    footerClass: "bg-whitesmoke",
    body: "Add the <code>bg-whitesmoke</code> class to the <code>footerClass</code> option.",
    buttons: [
        {
            text: "No Action!",
            class: "btn btn-primary btn-shadow",
            handler: function (modal) {},
        },
    ],
});

$("#modal-5").fireModal({
    title: "Login",
    body: $("#modal-login-part"),
    footerClass: "bg-whitesmoke",
    autoFocus: false,
    onFormSubmit: function (modal, e, form) {
        // Form Data
        let form_data = $(e.target).serialize();
        console.log(form_data);

        // DO AJAX HERE
        let fake_ajax = setTimeout(function () {
            form.stopProgress();
            modal
                .find(".modal-body")
                .prepend(
                    '<div class="alert alert-info">Please check your browser console</div>'
                );

            clearInterval(fake_ajax);
        }, 1500);

        e.preventDefault();
    },
    shown: function (modal, form) {
        console.log(form);
    },
    buttons: [
        {
            text: "Login",
            submit: true,
            class: "btn btn-primary btn-shadow",
            handler: function (modal) {},
        },
    ],
});

$("#modal-6").fireModal({
    body: "<p>Now you can see something on the left side of the footer.</p>",
    created: function (modal) {
        modal
            .find(".modal-footer")
            .prepend(
                '<div class="mr-auto"><a href="#">I\'m a hyperlink!</a></div>'
            );
    },
    buttons: [
        {
            text: "No Action",
            submit: true,
            class: "btn btn-primary btn-shadow",
            handler: function (modal) {},
        },
    ],
});

$(".oh-my-modal").fireModal({
    title: "My Modal",
    body: "This is cool plugin!",
});

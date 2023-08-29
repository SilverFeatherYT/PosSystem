// Start live search function
$(".search").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".option .select").filter(function () {
        $(this).toggle(
            $(this).find(".selectTitle").text().toLowerCase().indexOf(value) >
            -1
        );
    });
});
// End live search function

// Start calculate total function
function updateTotal() {
    const tbody = document.querySelector(".addProduct");
    let totalPrice = 0;

    for (let i = 0; i < tbody.children.length; i++) {
        const row = tbody.children[i];
        const price = parseFloat(row.children[2].textContent);
        let amount = parseInt(row.querySelector('input[type="text"]').value);
        if (isNaN(amount)) {
            amount = 0;
        }
        const total = price * amount;
        row.children[4].textContent = total.toFixed(2);
        totalPrice += total;
    }

    const totalInput = document.querySelector("#showtotal");
    totalInput.value = totalPrice.toFixed(2);
}
// End calculate total function

// Start delete row on table function
function removeRow(row) {
    const tbody = document.querySelector(".addProduct");

    if (row.parentNode === tbody) {
        tbody.removeChild(row);

        for (let i = 0; i < tbody.children.length; i++) {
            const numCell = tbody.children[i].children[0];
            numCell.textContent = i + 1;
        }

        updateTotal();
        calculateCashback();
    }
}
// End of delete row function

// Start add order to table function
function addProductToTable(name, price, minqty, qty) {
    // get the <tbody> element
    const tbody = document.querySelector(".addProduct");

    // check if the product already exists in the table
    const existingProductRow = Array.from(tbody.children).find((row) => {
        const productNameCell = row.querySelector("td:nth-child(2)");
        return productNameCell.textContent === name;
    });

    if (existingProductRow) {
        const amountInput = existingProductRow.querySelector(
            "td:nth-child(4) input"
        );
        const currentAmount = parseInt(amountInput.value);
        const newAmount = currentAmount + 1;

        const orderProductsInput = document.querySelector("#orderProducts");
        const orderProducts = JSON.parse(orderProductsInput.value || "[]");
        const existingProduct = orderProducts.find(
            (product) => product.product_name === name
        );

        existingProduct.product_qty = parseInt(amountInput.value);
        const existingQty = parseInt(existingProduct.product_qty) - 1;
        existingProduct.product_qty = existingQty;

        const disabledbtn = existingProductRow.querySelector(
            "td:nth-child(4) button:last-child"
        );
        if (existingQty >= qty - 1) {
            var message =
                "Selected Product " + name + " quantity is more than allowed. ";
            disabledbtn.disabled = true;
            toastr.info(message);
            return;
        }

        // Set the new value of amountInput only if it's less than or equal to the specified quantity
        if (newAmount <= qty) {
            amountInput.value = newAmount;
        }

        existingProduct.product_qty = parseInt(amountInput.value);
        orderProductsInput.value = JSON.stringify(orderProducts);

        updateTotal();
        calculateCashback();
        return;
    }

    toastr.options = {
        progressBar: true,
        closeButton: true,
    };
    if (qty <= minqty) {
        var message = "Product " + name + " quantity is low than " + qty;
        toastr.info(message);
        return;
    }

    // create a new row element
    const row = document.createElement("tr");

    // create the cells for the row
    const numCell = document.createElement("td");
    numCell.textContent = tbody.children.length + 1; // set the row number
    const nameCell = document.createElement("td");
    nameCell.textContent = name;
    const priceCell = document.createElement("td");
    priceCell.setAttribute("style", "display: none");
    priceCell.textContent = price;

    //create amount input field
    const amountCell = document.createElement("td");
    const amountInput = document.createElement("input");
    amountInput.type = "text";
    amountInput.min = 1;
    amountInput.value = 1;
    amountInput.addEventListener("input", updateTotal);
    amountInput.setAttribute(
        "style",
        "background-color:transparent; border:none; width:30px; text-align:center"
    );

    // create plus and minus buttons for the amount input
    const plusButton = document.createElement("button");
    plusButton.textContent = "+";
    plusButton.type = "button";
    plusButton.setAttribute("class", "btn btn-danger btn-sm");
    plusButton.addEventListener("click", () => {
        const orderProductsInput = document.querySelector("#orderProducts");
        const orderProducts = JSON.parse(orderProductsInput.value || "[]");
        const existingProduct = orderProducts.find(
            (product) => product.product_name === name
        );

        existingProduct.product_qty = parseInt(amountInput.value);
        const existingQty = parseInt(existingProduct.product_qty) - 1;
        existingProduct.product_qty = existingQty;

        if (existingQty >= qty - 1) {
            var message =
                "Selected Product " + name + " quantity is less than " + qty;
            plusButton.disabled = true;
            toastr.info(message);
            return;
        }

        amountInput.value = parseInt(amountInput.value) + 1;
        existingProduct.product_qty = parseInt(amountInput.value);
        orderProductsInput.value = JSON.stringify(orderProducts);

        updateTotal();
        calculateCashback();
    });
    const minusButton = document.createElement("button");
    minusButton.textContent = "-";
    minusButton.type = "button";
    minusButton.setAttribute("class", "btn btn-danger btn-sm");
    minusButton.addEventListener("click", () => {
        const orderProductsInput = document.querySelector("#orderProducts");
        const orderProducts = JSON.parse(orderProductsInput.value || "[]");
        const existingProduct = orderProducts.find(
            (product) => product.product_name === name
        );

        amountInput.value = parseInt(amountInput.value) - 1;
        if (amountInput.value < 1) {
            amountInput.value = 1;
        }
        existingProduct.product_qty = parseInt(amountInput.value);
        orderProductsInput.value = JSON.stringify(orderProducts);
        updateTotal();
        calculateCashback();
    });

    // add the plus and minus buttons to the amount cell
    amountCell.appendChild(minusButton);
    amountCell.appendChild(amountInput);
    amountCell.appendChild(plusButton);

    const prodTotalCell = document.createElement("td");
    prodTotalCell.textContent = price;

    // remove button fucntion
    const removeCell = document.createElement("td");
    //   remove button 1
    const removeButton = document.createElement("button");

    // Set the class attribute
    removeButton.setAttribute("class", "btn btn-danger btn-sm btnDelete");

    // Set the style attribute
    removeButton.setAttribute("style", "float:right;");

    // Create an <i> element for the icon
    const icon = document.createElement("i");
    icon.setAttribute("class", "fa fa-times");

    // Append the <i> element to the removeButton
    removeButton.appendChild(icon);
    removeButton.addEventListener("click", removeRow);
    removeButton.addEventListener("click", () => {
        const row = removeButton.closest("tr");
        removeRow(row);
        calculateCashback();
    });
    removeCell.appendChild(removeButton);

    // add the cells to the row
    row.appendChild(numCell);
    row.appendChild(nameCell);
    row.appendChild(priceCell);
    row.appendChild(amountCell);
    row.appendChild(prodTotalCell);
    row.appendChild(removeCell);

    // add the row to the table
    tbody.appendChild(row);

    const orderProduct = {
        product_name: name,
        product_qty: 1, // Default quantity is 1, you can modify this as needed
        product_price: price,
    };

    // Add the order product data to a hidden input field in the form
    const orderProductsInput = document.querySelector("#orderProducts");
    const orderProducts = JSON.parse(orderProductsInput.value || "[]");
    orderProducts.push(orderProduct);
    orderProductsInput.value = JSON.stringify(orderProducts);

    // update the total
    updateTotal();
    calculateCashback();
}
// End add order to table function

function attachAddProductListeners() {
    const addButtons = document.querySelectorAll(".select");
    addButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const product = JSON.parse(button.getAttribute("value"));
            addProductToTable(
                product.D_ProductName,
                product.D_ProductPrice,
                product.D_MinProductQty,
                product.D_ProductQty
            );
        });
    });
}

// Check if there is no product, payment option can not submit the form
function validateForm(event) {
    var selectedProducts = document.querySelectorAll(".addProduct tr");
    var selectedPaymentMethod = document.querySelector(
        'input[name="payment_method"]:checked'
    );

    if (selectedProducts.length === 0) {
        toastr.warning("Please select at least one product.");
        event.preventDefault();
        return false;
    }

    if (!selectedPaymentMethod) {
        toastr.warning("Please select a payment method.");
        event.preventDefault();
        return false;
    }

    var receiveCash = document.getElementById("receiveCash").value;

    var showTotalInput = document.getElementById("showtotal");

    var showTotal = parseFloat(showTotalInput.value);

    if (receiveCash === "") {
        toastr.error("Please enter cash amount.");
        event.preventDefault();
        return false;
    }
    if (receiveCash < showTotal) {
        toastr.error(
            "Received cash must be equal to or greater than the total amount."
        );
        event.preventDefault();
    } else {
        if (selectedPaymentMethod.value === "Credit Card") {
            $("#exampleModal").modal("show");
            event.preventDefault();
            return false;
        }
    }

    return true;
}
// Check if there is no product, payment option can not submit the form

// Handle credit card form submission
const creditCardForm = document.querySelector("#creditForm");
creditCardForm.addEventListener("submit", function (event) {
    event.preventDefault();

    // Close the credit card modal
    $("#exampleModal").modal("hide");

    // Submit the main form for addPos
    document.querySelector("#addPos").submit();
});

// function checkCustomerExists() {
//     const customerPhoneInput = document.getElementById("cusPhone");
//     const customerPhone = customerPhoneInput.value.trim();

//     if (!customerPhone) {
//         return true;
//     } else {
//         for (let i = 0; i < existingCustomerPhones.length; i++) {
//             if (existingCustomerPhones[i].includes(customerPhone)) {
//                 // Customer phone exists
//                 return true;
//             } else {
//                 // Customer phone doesn't exist
//                 console.log("Entered phone:", customerPhone);
//                 console.log("Existing phones:", existingCustomerPhones);
//                 toastr.error("Customer phone number does not exist.");
//                 customerPhoneInput.focus(); // Set focus on the input for correction
//                 return false;
//             }
//         }
//     }
// }

function countCustomerPhoneNumbers() {
    const totalPhoneNumbers = existingCustomerPhones.length;
    return totalPhoneNumbers;
}

const totalNumbers = countCustomerPhoneNumbers(existingCustomerPhones);
console.log("Total phone numbers:", totalNumbers);

// show receipt function
var myReceiptWindow;

function PrintReceiptContent(event) {
    if (myReceiptWindow && !myReceiptWindow.closed) {
        // Window is already open, display toastr info message
        toastr.info("Receipt window is already open.");
    } else {
        var data =
            '<input type="button" id="printPageButton class="printPageButton" style="display: block; width:100%; border: none; background-color: #008BBB; color: #fff; padding: 14px 28px; font-size: 16px; cursor:pointer; text-align:center" value="Print Receipt" onClick="window.print()">';

        data += `
        <html>
            <head>
                <title>Receipt</title>
            </head>
            <body>
                ${document.getElementById(event).innerHTML}
            </body>
        </html>
    `;
        myReceiptWindow = window.open(
            "",
            "myWin",
            "left=150, top=130, width=400, height=400"
        );
        myReceiptWindow.screnX = 0;
        myReceiptWindow.screnY = 0;
        myReceiptWindow.document.write(data);
        myReceiptWindow.document.title = "Print Receipt";
        myReceiptWindow.focus();
    }
}
// End show receipt function

let isCooldown = false;

// Scan Barcode Function
// function onScanSuccess(qrCodeMessage) {
//     if (isCooldown) {
//         // Scanning is currently inactive
//         return;
//     }

//     // Pause the scanning
//     isCooldown = true;

//     document.getElementById("result").innerHTML =
//         '<span class="result">' + qrCodeMessage + "</span>";

//     // Call the function to add the product to the table based on the scanned barcode
//     addProductByBarcode(qrCodeMessage);

//     setTimeout(() => {
//         isCooldown = false;
//     }, 1500);
// }

function addProductByBarcode(barcode) {

    // Fetch the product data from the server using barcode
    fetch(`/getProductByBarcode/${barcode}`)
        .then((response) => response.json())
        .then((data) => {
            var sound = new Audio(audioFileUrl);

            if (data.success) {
                const product = data.product;

                if (product) {
                    // Check if the selected product quantity is more than existingQty
                    const existingProductRow = Array.from(
                        document.querySelector(".addProduct").children
                    ).find((row) => {
                        const productNameCell =
                            row.querySelector("td:nth-child(2)");
                        return (
                            productNameCell.textContent ===
                            product.D_ProductName
                        );
                    });

                    if (existingProductRow) {
                        const existingQty = parseInt(
                            existingProductRow.querySelector(
                                "td:nth-child(4) input"
                            ).value
                        );

                        if (existingQty >= product.D_ProductQty - 1) {
                            toastr.info(
                                "Selected product quantity " +
                                product.D_ProductName +
                                " is more than allowed."
                            );
                            return; // Prevent further execution
                        }
                    }

                    // Add the product to the table and show success message
                    addProductToTable(
                        product.D_ProductName,
                        product.D_ProductPrice,
                        product.D_MinProductQty,
                        product.D_ProductQty
                    );

                    sound.play();
                    toastr.success(data.message);
                }
            } else {
                sound.play();
                toastr.error(data.message);
            }
        })
        .catch((error) => {
            toastr.error("Failed to fetch product details.");
            console.error(error);
        });
}

// var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
//     fps: 10,
//     qrbox: 250,
// });
// html5QrcodeScanner.render(onScanSuccess);

// End Scan Barcode Function


// New Barcode scanner
Quagga.init({
    inputStream: {
        name: "Live",
        type: "LiveStream",
        constraints: {
            width: 550,
            height: 300,
        },
        target: document.querySelector('#camera')
    },
    frequency: 2,
    decoder: {
        readers: ["ean_reader"],
    }
}, function (err) {
    if (err) {
        console.log(err);
        return;
    }
    console.log("Initialization finished. Ready to start");
    Quagga.start();
});

Quagga.onDetected(function (data) {
    var resultElement = document.getElementById("result");

    if (isCooldown) {
        // Scanning is currently inactive
        return;
    }

    // Pause the scanning
    isCooldown = true;

    // resultElement.innerHTML = "Scanned Barcode: " + data.codeResult.code;
    addProductByBarcode(data.codeResult.code);
    setTimeout(() => {
        isCooldown = false;
    }, 1000);
});



// Paginate without reload page
$(document).ready(function () {
    attachAddProductListeners();
    $(document).on("click", ".pagination a", function (e) {
        e.preventDefault();

        var page = $(this).attr("href").split("page=")[1];

        fetch_data(page);
    });

    function fetch_data(page) {
        var _token = $("input[name=_token]").val();

        $.ajax({
            url: "/Pos/Paginate?page=" + page,
            method: "POST",
            data: { _token: _token, page: page },
            success: function (data) {
                $("#card-2").html(data);
                attachAddProductListeners();
            },
        });
    }
});

// Function to calculate cashback
function calculateCashback() {
    const totalAmount = parseFloat(document.getElementById("showtotal").value);
    const receivedCash = parseFloat(
        document.getElementById("receiveCash").value
    );

    if (isNaN(receivedCash)) {
        document.getElementById("Cashback").value = "";
    } else {
        const cashback = receivedCash - totalAmount;
        document.getElementById("Cashback").value = cashback.toFixed(2);
    }
}

// Attach the function to the 'receiveCash' input's 'input' event
document
    .getElementById("receiveCash")
    .addEventListener("input", calculateCashback);

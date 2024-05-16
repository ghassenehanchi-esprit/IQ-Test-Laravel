<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IQ Test Certificate</title>
    <style>

        @import url('https://fonts.googleapis.com/css?family=Roboto:400,700');

        body {
            padding: 20px 0;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }

        .pm-certificate-container {
            position: relative;
            width: 800px;
            height: 600px;
            background-color: #fff;
            padding: 30px;
            color: #333;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        .outer-border, .inner-border {
            position: absolute;
            border: 2px solid #000;
        }

        .outer-border {
            width: 794px;
            height: 594px;
            left: 50%;
            margin-left: -397px;
            top: 50%;
            margin-top:-297px;
            background-size: cover;
        }

        .inner-border {
            background-color: white;
            width: 760px;
            height: 560px;
            left: 50%;
            margin-left: -380px;
            top: 50%;
            margin-top:-280px;
            opacity: 0.90;

        }
        .score-circle {
            width: 150px;
            display: flex;
            height: 150px;
            margin-left: 300px;
            margin-top: 50px;
            border-radius: 50%; /* Create a circle by setting border-radius to 50% */
            background-color: #c7c7c7; /* Background color of the circle */
            color: white; /* Text color */
            font-size: 25px; /* Font size of the score */
            line-height:40px; /* Center the text vertically */
            text-align: center; /* Center the text horizontally */
            justify-content: center;
            align-items: center;
            position: absolute;
            row-gap: 0px;
            opacity: 0.8;
            flex-direction: column;
        }


        .pm-certificate-border {
            position: relative;
            width: 720px;
            height: 520px;
            left: 50%;
            margin-left: -360px;
            top: 50%;
            margin-top: -260px;
        }

        .pm-certificate-header h2 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .pm-certificate-name {
            margin: 20px 0;
            font-size: 24px;
            font-weight: 700;
        }

        .pm-earned {
            margin: 10px 0;
            font-size: 18px;
        }

        .pm-course-title {
            margin: 10px 0;
            font-size: 18px;
            font-weight: 700;
        }

        .pm-certificate-footer {
            position: absolute;
            bottom: 30px;
            width: 100%;
            text-align: center;
        }

        .underline {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            display: inline-block;
            width: 300px;
            margin: 10px 0;
        }

        .gold-band {
            position: absolute;
            background-color: gold;
            width: 20px; /* Adjust width as needed */
            height: 91%;
            left: 50%;
            margin-left: 330px; /* Adjust margin-left to position the gold band */
            top: 50%;
            margin-top: -298px; /* Adjust margin-top to position the gold band */
            z-index: 1; /* Ensure the gold band appears on top of other elements */
        }

        .logo {
            position: absolute;
            left: 50%;
            width: 250px;
            margin-left: 50px; /* Adjust margin-left to position the gold band */
            top: 50%;
            margin-top: -218px; /* Adjust margin-top to position the gold band */
            z-index: 1; /* Ensure the gold band appears on top of other elements */
        }

    </style>
</head>
<body>
<div id="pdfContent">
    <div class="container pm-certificate-container">
        <div class="outer-border" style="background-image: url('{{ asset('backkk.jpg') }}');"></div>
        <div class="inner-border"></div>

        <div class="pm-certificate-border col-xs-12">
            <div class="row pm-certificate-header">
                <div class="pm-certificate-title col-xs-12 text-center">
                    <h2>IQ Test Global</h2>
                </div>
            </div>

            <div class="row pm-certificate-body">
                <div class="pm-certificate-block">
                    <div class="col-xs-12 text-center">
                        <div class="pm-certificate-name underline">
                            <span class="pm-name-text bold">{{$fullName}}</span>
                        </div>
                        <div class="pm-earned">
                  <span class="pm-earned-text"
                  >has successfully completed the IQ test</span
                  >
                        </div>
                        <div class="pm-course-title underline">
                            <span class="pm-credits-text bold">IQ Global test</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 pm-certificate-footer">
                    <div class="pm-certified text-center">
                        <span class="pm-credits-text">[Institution Name]</span>
                        <div class="pm-empty-space underline"></div>
                        <span class="bold">[Issuer's Name and Title]</span>
                    </div>
                    <div class="pm-certified text-center">
                        <span class="pm-credits-text">Date Completed</span>
                        <div class="pm-empty-space underline"></div>
                        <span class=“bold”>{{ getCurrentDate()}}</span>

                    </div>
                </div>
            </div>
        </div>
        <div class="gold-band"></div>
        <img class="logo" src="{{ asset('iqtest.png') }}" alt="Logo" />
        <div class="score-circle">
            <div>Your Score</div>
            <div><strong>{{$order->quizz->quizz_score}} / {{calculateTotalQuizScore($order->quizz->id)}}</strong></div>
        </div>
    </div>
</div>
<!-- Button to trigger PDF download -->
<button onclick="downloadPDF()">Download Certificate as PDF</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- Script to handle PDF download -->
<script>
    function downloadPDF() {
        // Select the div with id 'pdfContent' for PDF conversion
        const element = document.getElementById('pdfContent');

        // Options for the PDF generation
        const options = {
            margin: 10,
            filename: 'certificate.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        // Use html2pdf to download the PDF
        html2pdf().from(element).set(options).save();
    }
</script>

</body>
</html>

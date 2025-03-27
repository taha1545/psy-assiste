<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $folder->folder_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            background-color: white;
        }

        .document-page {
            width: 210mm;
            height: 297mm;
            margin: auto;
            background-color: white;
            padding: 20mm;
            box-sizing: border-box;
            border: 1px solid #ddd;
        }

        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .official-titles h1 {
            font-size: 20px;
            font-weight: bold;
        }

        .official-titles h2 {
            font-size: 16px;
            font-weight: bold;
        }

        .institution-info h4,
        .institution-info h5 {
            font-size: 14px;
            margin: 2px 0;
        }

        .patient-info-section {
            display: flex;
            justify-content: space-between;
            width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }

        .patient-details,
        .patient-number {
            width: 48%;
        }

        .patient-field {
            display: flex;
            margin-bottom: 5px;
        }

        .patient-field label {
            font-weight: bold;
            min-width: 100px;
        }

        .request-content {
            text-align: justify;
        }

        .request-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
            font-weight: bold;
        }

        .date-section {
            margin-top: 30px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="document-page">

        <div class="header-section">
            <div class="official-titles">
                <h1>الجمهورية الجزائرية الديمقراطية الشعبية</h1>
                <h2>REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE</h2>
            </div>
            <div class="institution-info">
                <h4>اسم المؤسسة</h4>
                <h5>..............................................................................</h5>
            </div>
        </div>

        <div class="patient-info-section">
            <div class="patient-details">
                <div class="patient-field">
                    <label>Nom:</label>
                    <p>Taha</p>
                </div>
                <div class="patient-field">
                    <label>Prénom:</label>
                    <p>Mansouri</p>
                </div>
                <div class="patient-field">
                    <label>Date de naissance:</label>
                    <p>{{ \Carbon\Carbon::parse($folder->birth_date)->format('d/m/Y') }}</p>
                </div>
                <div class="patient-field">
                    <label>Adresse:</label>
                    <p>{{ $folder->full_address ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="patient-number">
                <label>N° :</label>
                <p>................</p>
            </div>
        </div>

        <div class="request-content">
            <h2 class="request-title">DEMANDE D'AVIS</h2>

            <p>Cher confrère,</p>

            <p>
                Permettez-moi de vous adresser le (a) patient(e) sus nommé âgé de .................
            </p>
            <p>
                ans, qui présente : <span class="input-field">......................................</span>
            </p>
            <p>
                depuis <span class="input-field">.................................</span>
            </p>

            <p>Je vous le confie pour un avis spécialisé. Confraternellement.</p>

            <div class="date-section">
                <p>Fait à : <span class="input-field">...........................................</span></p>
                <p>Le : <span class="input-field">{{ now()->format('d/m/Y H:i') }}</span></p>
            </div>

            <div class="signature-section">
                <p>Signature du psychologue</p>
            </div>

        </div>
    </div>
</body>

</html>

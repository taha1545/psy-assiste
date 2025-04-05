<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>psyco</title>
    <style>
        <style>* {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            background-color: white;
            font-size: 14px;
            line-height: 1.6;
        }

        .document-page {
            width: 100%;
            padding: 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .official-titles h1,
        .official-titles h2 {
            margin: 0;
            font-size: 18px;
        }

        .institution-info h4,
        .institution-info h5 {
            margin: 5px 0;
            font-size: 14px;
        }

        .patient-info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            padding: 10px;
        }

        .patient-details {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }

        .patient-number {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: right;
        }

        .patient-field {
            margin-bottom: 8px;
        }

        .patient-field label {
            font-weight: bold;
            display: inline-block;
            width: 140px;
        }

        .patient-field p,
        .patient-number p {
            display: inline-block;
            margin: 0;
            min-width: 200px;
            padding: 0 4px;
        }

        .patient-number label {
            font-weight: bold;
        }

        .request-content {
            margin-top: 30px;
        }

        .request-title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 30px;
            text-decoration: underline;
        }

        .request-paragraph {
            margin-bottom: 20px;
        }

        .medical-description p {
            margin: 10px 0;
        }

        .input-field {
            display: inline-block;
            min-width: 200px;
            padding: 0 5px;
        }

        .center-text {
            text-align: center;
            margin: 30px 0;
        }

        .date-section p {
            margin: 8px 0;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
        }

        .signature-line {
            font-style: italic;
        }
    </style>

    </style>
</head>

<body>
    <div class="document-page">

        <div class="header-section">
            <div class="official-titles">
                <h1>الشعبية الديمقراطية الجزائرية الجمهورية</h1>
                <h2>REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE </h2>
            </div>
            <div class="institution-info">
                <h4> اسم المؤسسة</h4>
                <h5>..............................................................................</h4>
            </div>
        </div>
        <div class="patient-info-section">

            <div class="patient-details">
                <div class="patient-field">
                    <label>Nom :</label>
                    <p>
                        @php
                            $parts = explode(' ', $folder->folder_name ?? '');
                            echo count($parts) > 1 ? end($parts) : 'N/A';
                        @endphp
                    </p>
                </div>
                <div class="patient-field">
                    <label>Prénom :</label>
                    <p>
                        @php
                            $parts = explode(' ', $folder->folder_name ?? '');
                            echo count($parts) > 1 ? implode(' ', array_slice($parts, 0, -1)) : ($folder->folder_name ?? 'N/A');
                        @endphp
                    </p>
                </div>
                <div class="patient-field">
                    <label>Date de naissance :</label>
                    <p>{{ $folder->birth_date ?? 'N/A' }}</p>
                </div>
                <div class="patient-field">
                    <label>Adresse :</label>
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

            <p class="request-paragraph">Cher confrère,</p>
            <div class="medical-description">
                <p class="patient-condition">
                    Permettez-moi de vous adresser le (a) patient(e) sus nommé âgé de .................
                </P>
                <P>
                    ans, Qui présente :
                    <span
                        class="input-field">........................................................................................................</span>
                </p>
                <p>
                    <span
                        class="input-field">........................................................................................................................................</span>
                </p>
                <p>
                    depuis <span class="input-field">.................................</span>
                </p>
            </div>

            <p class="center-text">Je vous le confie pour un avis spécialisé Confraternellement.</p>


            <div class="date-section">
                <p>Fait à : <span class="input-field">...........................................</span>
                </p>
                <p>Le : <span class="input-field">.............................................</span></p>
            </div>
            <div class="signature-section">
                <p class="signature-line">Signature du psychologue</p>
            </div>
        </div>
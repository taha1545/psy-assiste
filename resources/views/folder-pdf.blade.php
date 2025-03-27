<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $folder->folder_name }}</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
            background-color: gray;
        }

        .document-page {
            background-color: white;
            margin: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        .header-section {
            display: flex;
            align-items: center;
            flex-direction: column;
            width: 85%;
            justify-content: center;
            margin-bottom: 25px;
        }

        .official-titles {
            margin-top: 75px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            text-align: center;
            font-weight: bold;
            font-size: normal;
            font-style: italic;
        }

        .official-titles h1,
        .official-titles h2 {
            margin: 2px 0;
            padding: 0;
        }

        .official-titles h2 {
            font-weight: bold;
            font-size: 100%;
            font-style: normal;
        }

        .institution-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
            text-align: center;
        }

        .institution-info h4 {
            margin: 3px 0;
            padding: 0;
            font-weight: 200;
            font-size: 92%;
        }

        .institution-info h5 {
            margin: 2px 0;
            padding: 0px;
            font-size: large;
            font-weight: 300;
        }

        .patient-info-section {
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            width: 80%;
            height: 120px;
            padding: 10px;
            font-family: Arial, sans-serif;
        }

        .patient-details {
            display: flex;
            flex-direction: column;
            width: 50%;
        }

        .patient-field {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            margin-bottom: 0px;
            height: 25px;
        }

        .patient-field:last-child {
            margin-bottom: 0;
        }

        .patient-field label {
            font-weight: bold;
            min-width: 80px;
            font-size: small;
            padding: 0px;
        }

        .patient-field p {
            flex-grow: 1;
            font-size: small;
        }

        .patient-number {
            text-align: right;
            min-width: 80px;
        }

        .patient-number label {
            font-weight: bold;
            font-size: small;
        }

        .patient-number p {
            display: inline-block;
        }

        .request-content {
            width: 80%;
            max-width: 800px;
            margin: 0;
            padding: 0;
        }

        .request-title {
            text-align: center;
            font-size: 28px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .request-paragraph {
            font-size: 24px;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .input-field {
            display: inline-block;
            min-width: 250px;
            text-align: center;
        }

        .signature-line {
            text-align: right;
            font-size: 22px;
            margin-right: 15%;
        }

        .patient-condition {
            margin: 3px;
            padding: 0px;
            margin-left: 30px;
        }

        .center-text {
            width: 100%;
            text-align: center;
            margin: 0;
            font-size: 18px;
        }

        .medical-description {
            height: 150px;
            margin: 0px;
            padding: 0;
            font-size: 18px;
        }

        .medical-description p {
            margin: 2px 0;
            padding: 0;
        }

        .date-section {
            padding: 0;
            padding-top: 75px;
            width: 100%;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }

        .date-section p {
            font-size: 16px;
            margin: 2px 0;
            padding: 0;
            display: flex;
            justify-content: flex-start;
            max-width: 300px;
            width: 25%;
            white-space: nowrap;
            padding-right: 15%;
        }

        .date-section p .input-field {
            flex-grow: 1;
            text-align: left;
            display: inline-block;
            min-width: 100px;
        }

        .signature-section {
            padding-top: 4%;
            width: 100%;
            height: 225px;
        }
    </style>
</head>

<body>
    <div class="document-page">

        <div class="header-section">
            <div class="official-titles">
                <h1>الجمهورية الجزائرية الديمقراطية الشعبية</h1>
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
                    <p>taha</p>
                </div>
                <div class="patient-field">
                    <label>Prenom :</label>
                    <p>mansouri</p>
                </div>
                <div class="patient-field">
                    <label>Date de naissance :</label>
                    <p>{{ \Carbon\Carbon::parse($folder->birth_date)->format('d/m/Y') }}</p>
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
                <p>Le : <span class="input-field">{{ now()->format('d/m/Y H:i') }}</span></p>
            </div>
            <div class="signature-section">
                <p class="signature-line">Signature du psychologue</p>
            </div>
        </div>

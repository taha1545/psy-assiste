<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>psyco</title>
    <style>
        * {
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
            margin-bottom: 35px;
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
            text-align: left;
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
</head>

<body>
    <div class="document-page">

         <div class="header-section">
            <div class="official-titles">
                <img src={{asset('arab.png')}}>
                <h2>REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE </h2>
            </div>
            <div class="institution-info">
                <h4>Nom de l'institution</h4>
                <h5>..............................................................................</h4>
            </div>
        </div>
        <div class="patient-info-section">
            <div class="patient-number">
                <label>N° :</label>
                <p>................</p>
            </div>
        </div>
        <div class="request-content">
            <h2 class="request-title">CERTIFICAT DE BONNE SANTE MENTALE</h2>

            <p class="request-paragraph">Je soussigné, certifie avoir reçu et examiné ce jour le nommé :</p>
            <p><span class="input-field">.{{ $folder->folder_name }}</span></p>
            <p>né(e) le : <span class="input-field">.......{{  $folder->birth_date  ?? 'N/A' }}......</span> à : <span class="input-field">.......{{  $folder->full_address ?? 'N/A' }}...........</span></p>
            <p>et déclare qu’il(elle) ne présente aucun trouble mental symptomatique d'une affection mentale caractérisée et avérée, ni aucun signe de souffrance mentale cliniquement évolutive, ce jour.</p>
            <p>Par conséquent, sa condition mentale lui permet de réaliser tous les actes de la vie civile.</p>
            <p>Dont certificat délivré à la demande de l'intéressé pour servir et valoir ce que de droit.</p>

            <div class="date-section">
                <p>Fait à : <span class="input-field">...........................................</span></p>
                <p>Le : <span class="input-field">.............................................</span></p>
            </div>

            <div class="signature-section">
                <p class="signature-line">Signature du psychologue</p>
            </div>
        </div>

    </div>
</body>

</html>

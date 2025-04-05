<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Psychological Report</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            padding: 30px;
        }

        .document-page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .official-titles h1 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .official-titles h2 {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .institution-info h4 {
            font-size: 15px;
            margin: 15px 0;
        }

        .patient-info-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
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
            margin-bottom: 10px;
            display: flex;
            align-items: baseline;
        }

        .patient-field label {
            font-weight: bold;
            min-width: 140px;
        }

        .request-title {
            text-align: center;
            font-size: 20px;
            margin: 30px 0;
            text-decoration: underline;
        }

        .request-paragraph {
            margin-bottom: 15px;
            text-align: justify;
        }

        .date-section p {
            margin: 15px 0;
        }

        .signature-section {
            margin-top: 80px;
            text-align: right;
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
                <p>..............................................................................</p>
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
                <div class="patient-field">
                    <label>N° :</label>
                    <p>................</p>
                </div>
            </div>
        </div>

        <div class="request-content">
            <h2 class="request-title">Rapport Psychologique</h2>

            <div class="report-content">
                <p class="request-paragraph">
                    ...........................................................................................................................................................................................
                    ...........................................................................................................................................................................................
                    ..........................................................................................................................................................................................
                    ...........................................................................................................................................................................................
                    ...........................................................................................................................................................................................
                    ..........................................................................................................................................................................................
                    ...........................................................................................................................................................................................
                    ...........................................................................................................................................................................................
                    ..........................................................................................................................................................................................

                </p>
            </div>
        </div>

        <div class="date-section">
            <p>Fait à : .................................</p>
            <p>Le : .....................................</p>
        </div>

        <div class="signature-section">
            <p>Signature du psychologue</p>
        </div>
    </div>
</body>

</html>
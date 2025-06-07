<!-- resources/views/cahier_texte_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cahier de Texte</title>
    <style>
        *{
            margin:0;
            padding:10;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;

        }
        h1 {
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .details td {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
<img class="header-img" src="{{ public_path('img/emsi.png') }}" alt="EMS Logo" style="margin-bottom: 30px;">


    <h1>Cahier de Texte</h1>

    <div class="details">
        <table>
            <tr>
                <th>Module</th>
                <td>{{ $cahierTexte->module_name }}</td>
            </tr>
            <tr>
                <th>Filière</th>
                <td>{{ $cahierTexte->filiere_name }}</td>
            </tr>
            <tr>
                <th>Groupe</th>
                <td>{{ $cahierTexte->groupe_name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $cahierTexte->date }}</td>
            </tr>
            <tr>
                <th>Titre</th>
                <td>{{ $cahierTexte->titre }}</td>
            </tr>
            <tr>
                <th>Objectifs</th>
                <td>{{ $cahierTexte->objectifs }}</td>
            </tr>
            <tr>
                <th>Contenu</th>
                <td>{{ $cahierTexte->contenu }}</td>
            </tr>
            <tr>
                <th>Devoirs</th>
                <td>{{ $cahierTexte->devoirs }}</td>
            </tr>
        </table>
    </div>

</body>
</html>

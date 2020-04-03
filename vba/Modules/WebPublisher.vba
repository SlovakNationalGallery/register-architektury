Option Explicit

Sub ExportTbls(ByVal endpoint As String, ByVal dsnName As String)
    Const EXPORT_TYPE = "ODBC Database"

    Dim connectionString As String
    Dim tableName As String
    Dim startTime As Variant
    Dim db As Database
    Dim tableDef As DAO.tableDef
    Dim query As QueryDef

    On Error GoTo ExportTbls_Error
    startTime = Timer
    connectionString = "ODBC;DSN=" & dsnName

    Debug.Print "Re-setting the destination Database..."
    Call ResetSync(endpoint)

    Set db = CurrentDb()

    For Each tableDef In db.TableDefs
        Debug.Print tableDef.Name

        'Don't export System and temporary tables
        If Left(tableDef.Name, 4) <> "MSys" And Left(tableDef.Name, 4) <> "~TMP" Then
            tableName = tableDef.Name
            DoCmd.TransferDatabase acExport, EXPORT_TYPE, connectionString, acTable, tableName, tableName
        End If
    Next tableDef

    Call StartSync(endpoint)

    On Error GoTo 0

SmoothExit_ExportTbls:
    Set db = Nothing
    Application.Echo True
    Exit Sub

ExportTbls_Error:
    MsgBox "Vyskytla sa chyba!"
    Err.Raise Err.Number, "ExportTbls", Err.Description
End Sub

Private Sub ResetSync(ByVal endpoint As String)
    Call PostToApi(endpoint, "/api/sync/reset")
End Sub

Private Sub StartSync(ByVal endpoint As String)
    Call PostToApi(endpoint, "/api/sync/start")
End Sub

Private Sub PostToApi(ByVal endpoint As String, ByVal url As String)
    Dim request As String
    Dim xmlHttp As Object

    Set xmlHttp = CreateObject("MSXML2.XMLHTTP")
    request = endpoint & url

    xmlHttp.Open "POST", request, False
    xmlHttp.send
End Sub


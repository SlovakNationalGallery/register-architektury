Option Compare Database

Const STATUS_LABEL_CONTROL = "StatusLabel"

Private Sub PublishButton_Click()
    Dim endpoint As String
    Dim dsnName As String

    On Error GoTo CatchError

    endpoint = Me.Form.Controls("EndpointInput").Value
    dsnName = Me.Form.Controls("DsnNameInput").Value

    Me.Form.Controls(STATUS_LABEL_CONTROL).Caption = "Moment..."
    Me.Form.Repaint

    Call WebPublisher.ExportTbls(endpoint, dsnName)

Done:
    Me.Form.Controls(STATUS_LABEL_CONTROL).Caption = "Zmeny boli publikované!"
    Exit Sub
CatchError:
    Me.Form.Controls(STATUS_LABEL_CONTROL).Caption = "Chyba: " & Err.Description
End Sub

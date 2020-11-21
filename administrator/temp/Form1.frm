VERSION 5.00
Begin VB.Form Form1 
   Caption         =   "Form1"
   ClientHeight    =   3195
   ClientLeft      =   60
   ClientTop       =   345
   ClientWidth     =   4680
   LinkTopic       =   "Form1"
   ScaleHeight     =   3195
   ScaleWidth      =   4680
   StartUpPosition =   3  'Windows Default
   Begin VB.CommandButton Command1 
      Caption         =   "Command1"
      Height          =   855
      Left            =   1050
      TabIndex        =   0
      Top             =   990
      Width           =   1845
   End
End
Attribute VB_Name = "Form1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Private Sub Command1_Click()
  '
  'Define the three objects that we need,
  '   A Connection Object - connects to our data source
  '   A Command Object - defines what data to get from the data source
  '   A RecordSet Object - stores the data we get from our data source
  '
  Dim conConnection As New ADODB.Connection
  Dim cmdCommand As New ADODB.Command
  Dim rstRecordSet As New ADODB.Recordset
  
  '
  'Defines the connection string for the Connection.  Here we have used fields
  'Provider, Data Source and Mode to assign values to the properties
  ' conConnection.Provider and conConnection.Mode
  '
  conConnection.ConnectionString = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & _
    App.Path & "\" & "database.mdb;Mode=Read|Write"
    
  '
  'Define the location of the cursor engine, in this case we are opening an Access database
  'and adUseClient is our only choice.
  '
  conConnection.CursorLocation = adUseClient
  
  '
  'Opens our connection using the password "Admin" to access the database.  If there was no password
  'protection on the database this field could be left out.
  '
  conConnection.Open
  
  '
  'Defines our command object
  '
  ' .ActiveConnection tells the command to use our newly created command object.
  ' .CommandText tells the command how to get the data, in this case the command
  '              will evaluate the text as an SQL string and we will return all
  '              records from a table called tabTestTable
  ' .CommandType tells the command to evaluate the .CommandText property as an SQL string.
  '
  With cmdCommand
    .ActiveConnection = conConnection
    .CommandText = "SELECT * FROM tabTestTable;"
    .CommandType = adCmdText
  End With
  '
  'Defines our RecordSet object.
  '
  '  .CursorType sets a static cursor, the only choice for a client side cursor
  '  .CursorLocation sets a client side cursor, the only choice for an Access database
  '  .LockType sets an optimistic lock type
  '  .Open executes the cmdCommand object against the data source and stores the
  '        returned records in our RecordSet object.
  '
  With rstRecordSet
    .CursorType = adOpenStatic
    .CursorLocation = adUseClient
    .LockType = adLockOptimistic
    .Open cmdCommand
  End With
  '
  'Firstly test to see if any records have been returned, if some have been returned then
  'the .EOF property of the RecordSet will be false, if none have been returned then the
  'property will be true.
  '
  If rstRecordSet.EOF = False Then
    '
    'Move to the first record
    '
    rstRecordSet.MoveFirst
    '
    'Lets move through the records one at a time until we reach the last record
    'and print out the values of each field
    '
    Do
      '
      'Access the field values using the fields collection and print them to a message box.
      'In this case I do not know what you might call the columns in your database so this
      'is the safest way to do it.  If I did know the names of the columns in your table
      'and they were called "Column1" and "Column2" I could reference their values using:
      '
      '  rstRecordSet!Column1
      '  rstRecordSet!Column2
      '
      '
      MsgBox "Record " & rstRecordSet.AbsolutePosition & " " & _
        rstRecordSet.Fields(0).Name & "=" & rstRecordSet.Fields(0) & " " & _
        rstRecordSet.Fields(1).Name & "=" & rstRecordSet.Fields(1)
      '
      'Move to the next record
      '
      rstRecordSet.MoveNext
    Loop Until rstRecordSet.EOF = True
    '
    'Add a new record
    '
    With rstRecordSet
      .addNew
        .Fields(0) = "New"
        .Fields(1) = "Record"
      .Update
    End With
    '
    'Move back to the first record and delete it
    '
    rstRecordSet.MoveFirst
    rstRecordSet.Delete
    rstRecordSet.Update
    
    '
    'Close the recordset
    '
    rstRecordSet.Close
  Else
    MsgBox "No records were returned using the query " & cmdCommand.CommandText
  End If
  '
  'Close the connection
  '
  conConnection.Close
  '
  'Release your variable references
  '
  Set conConnection = Nothing
  Set cmdCommand = Nothing
  Set rstRecordSet = Nothing
End Sub

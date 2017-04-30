# Script directory
$basedir = Convert-Path $(Split-Path -Path $MyInvocation.InvocationName -Parent)
Set-Location $basedir

# Create web client object
$WebClient = New-Object System.Net.WebClient

Write-Output "Thank you very much for using ExtraCorePE installer!"

$input = Read-Host "Do you want starting installer? (y/n)"
switch($input)
{
  "y" {Write-Output "Starting installer..."}
  "n" {Write-Output "Shutdown installer..." exit}
  default {Write-Output "[Error] Unknown input" exit 1}
}

# ZIP file download
$srcUrl = "https://github.com/ExtraCorePE/ExtraCorePE.git"
$zipName = [System.IO.Path]::GetFileName($srcUrl)
$zipPath = [System.IO.Path]::Combine($basedir, $zipName)
Write-Output "Downloading ExtraCorePE..."
$WebClient.DownloadFile($srcUrl, $zipPath)

# ZIP file open
$sh = New-Object -ComObject Shell.Application
$unzipDirObj = $sh.NameSpace($basedir)
$zipPathObj = $sh.NameSpace($zipPath)
Write-Output "install ExtraCorePE..."
$unzipDirObj.CopyHere($zipPathObj.Items())
Write-Output "Done! ExtraCorePE install completed!"
Write-Output "Have a nice day!"
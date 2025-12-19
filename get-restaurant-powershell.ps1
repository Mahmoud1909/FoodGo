# Get Restaurant Data using PowerShell and Firebase REST API

$RestaurantId = "5KjbF2LDaEe19ttEFClo"
$ProjectId = "foodgo-e1252"

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Fetching Restaurant Data from Firestore" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Restaurant ID: $RestaurantId" -ForegroundColor Yellow
Write-Host "Collection: vendors" -ForegroundColor Yellow
Write-Host "Project ID: $ProjectId" -ForegroundColor Yellow
Write-Host "============================================" -ForegroundColor Cyan

# Try to get access token using gcloud
$accessToken = ""
try {
    $accessToken = gcloud auth print-access-token 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "WARNING: gcloud not available, trying alternative method..." -ForegroundColor Yellow
        $accessToken = ""
    }
} catch {
    Write-Host "WARNING: gcloud not available" -ForegroundColor Yellow
}

if ($accessToken -eq "") {
    Write-Host ""
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: Cannot get access token" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Solutions:" -ForegroundColor Yellow
    Write-Host "   1. Install gcloud CLI: https://cloud.google.com/sdk/docs/install" -ForegroundColor White
    Write-Host "   2. Run: gcloud auth login" -ForegroundColor White
    Write-Host "   3. Or use Node.js script: node get-restaurant-by-id.js" -ForegroundColor White
    Write-Host "   4. Or use Firebase CLI: firebase firestore:get vendors/$RestaurantId" -ForegroundColor White
    exit 1
}

$url = "https://firestore.googleapis.com/v1/projects/$ProjectId/databases/(default)/documents/vendors/$RestaurantId"

Write-Host ""
Write-Host "Calling Firestore API..." -ForegroundColor Cyan

try {
    $response = Invoke-RestMethod -Uri $url -Method Get -Headers @{
        "Authorization" = "Bearer $accessToken"
    }
    
    Write-Host ""
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host "SUCCESS: Data fetched successfully!" -ForegroundColor Green
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "RESTAURANT DATA:" -ForegroundColor Cyan
    Write-Host "============================================" -ForegroundColor Cyan
    Write-Host ""
    
    # Print formatted JSON
    $response | ConvertTo-Json -Depth 10
    
    Write-Host ""
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host "SUCCESS: Done!" -ForegroundColor Green
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    
} catch {
    Write-Host ""
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: Failed to fetch restaurant data" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    exit 1
}


$RestaurantId = "5KjbF2LDaEe19ttEFClo"
$ProjectId = "foodgo-e1252"

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Fetching Restaurant Data from Firestore" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Restaurant ID: $RestaurantId" -ForegroundColor Yellow
Write-Host "Collection: vendors" -ForegroundColor Yellow
Write-Host "Project ID: $ProjectId" -ForegroundColor Yellow
Write-Host "============================================" -ForegroundColor Cyan

# Try to get access token using gcloud
$accessToken = ""
try {
    $accessToken = gcloud auth print-access-token 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "WARNING: gcloud not available, trying alternative method..." -ForegroundColor Yellow
        $accessToken = ""
    }
} catch {
    Write-Host "WARNING: gcloud not available" -ForegroundColor Yellow
}

if ($accessToken -eq "") {
    Write-Host ""
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: Cannot get access token" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Solutions:" -ForegroundColor Yellow
    Write-Host "   1. Install gcloud CLI: https://cloud.google.com/sdk/docs/install" -ForegroundColor White
    Write-Host "   2. Run: gcloud auth login" -ForegroundColor White
    Write-Host "   3. Or use Node.js script: node get-restaurant-by-id.js" -ForegroundColor White
    Write-Host "   4. Or use Firebase CLI: firebase firestore:get vendors/$RestaurantId" -ForegroundColor White
    exit 1
}

$url = "https://firestore.googleapis.com/v1/projects/$ProjectId/databases/(default)/documents/vendors/$RestaurantId"

Write-Host ""
Write-Host "Calling Firestore API..." -ForegroundColor Cyan

try {
    $response = Invoke-RestMethod -Uri $url -Method Get -Headers @{
        "Authorization" = "Bearer $accessToken"
    }
    
    Write-Host ""
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host "SUCCESS: Data fetched successfully!" -ForegroundColor Green
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "RESTAURANT DATA:" -ForegroundColor Cyan
    Write-Host "============================================" -ForegroundColor Cyan
    Write-Host ""
    
    # Print formatted JSON
    $response | ConvertTo-Json -Depth 10
    
    Write-Host ""
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    Write-Host "SUCCESS: Done!" -ForegroundColor Green
    Write-Host "SUCCESS: ============================================" -ForegroundColor Green
    
} catch {
    Write-Host ""
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: Failed to fetch restaurant data" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "ERROR: ============================================" -ForegroundColor Red
    exit 1
}


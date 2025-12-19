#!/bin/bash
# Get Restaurant Data using gcloud CLI

RESTAURANT_ID="5KjbF2LDaEe19ttEFClo"
PROJECT_ID="foodgo-e1252"

echo "🔍 ============================================"
echo "🔍 Fetching Restaurant Data using gcloud CLI"
echo "🔍 ============================================"
echo "🔍 Restaurant ID: $RESTAURANT_ID"
echo "🔍 Collection: vendors"
echo "🔍 Project ID: $PROJECT_ID"
echo "🔍 ============================================"

# Get document
gcloud firestore documents get vendors/$RESTAURANT_ID --project=$PROJECT_ID

echo ""
echo "✅ ============================================"
echo "✅ Done!"
echo "✅ ============================================"


# Get Restaurant Data using gcloud CLI

RESTAURANT_ID="5KjbF2LDaEe19ttEFClo"
PROJECT_ID="foodgo-e1252"

echo "🔍 ============================================"
echo "🔍 Fetching Restaurant Data using gcloud CLI"
echo "🔍 ============================================"
echo "🔍 Restaurant ID: $RESTAURANT_ID"
echo "🔍 Collection: vendors"
echo "🔍 Project ID: $PROJECT_ID"
echo "🔍 ============================================"

# Get document
gcloud firestore documents get vendors/$RESTAURANT_ID --project=$PROJECT_ID

echo ""
echo "✅ ============================================"
echo "✅ Done!"
echo "✅ ============================================"








#!/bin/bash
# Get Restaurant Data using Firebase CLI

RESTAURANT_ID="5KjbF2LDaEe19ttEFClo"

echo "🔍 ============================================"
echo "🔍 Fetching Restaurant Data using Firebase CLI"
echo "🔍 ============================================"
echo "🔍 Restaurant ID: $RESTAURANT_ID"
echo "🔍 Collection: vendors"
echo "🔍 ============================================"

# Method 1: Using Firebase CLI
firebase firestore:get vendors/$RESTAURANT_ID

echo ""
echo "✅ ============================================"
echo "✅ Done!"
echo "✅ ============================================"





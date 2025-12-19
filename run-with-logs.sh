#!/bin/bash

echo "========================================"
echo "Starting Laravel Server with Logs"
echo "========================================"
echo ""
echo "This will start the Laravel development server"
echo "and show all logs in the terminal."
echo ""
echo "Press Ctrl+C to stop the server"
echo ""
echo "========================================"
echo ""

# Clear Laravel logs
if [ -f storage/logs/laravel.log ]; then
    rm storage/logs/laravel.log
fi

# Start Laravel server with verbose output
php artisan serve --host=127.0.0.1 --port=8000


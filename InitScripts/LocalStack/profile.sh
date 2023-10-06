#!/bin/bash
aws --endpoint-url=http://localhost:4566 configure set aws_access_key_id "qualquer"
aws --endpoint-url=http://localhost:4566 configure set aws_secret_access_key "qualquer"
aws --endpoint-url=http://localhost:4566 configure set region "us-east-1"
aws --endpoint-url=http://localhost:4566 configure set output "text"
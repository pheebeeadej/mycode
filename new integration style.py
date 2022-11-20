def zoedata_vending(plan,num):
                    url = "https://www.zoedata.com.ng/api/mtnsme.php?"
                    payload =  f"api_key=7ff929b69227a388e8c48ee604a42bf1&network=MTN&plans={plan}&phonenumber={num}&return_url=https://zoedata.com.ng"
​
                    headers = {
                        
                        'Content-Type': 'application/json'
                        }
​
​
                    print(url)
                    print(headers)
                    print(payload)
​
                    try:
                            response = requests.get(url+payload, headers=headers, data = json.dumps(payload))
                            print("##################################################################")
                            print("#######################zoedata_vending#####################################")
                            print(response.text)
                            print(response.status_code)
                          
                            if response.status_code == 200 or response.status_code == 201:
                                resp = json.loads(response.text)
                        
                                if "status" in resp and "success":
                                    return "successful"
                                else:
                                    return "failed"
                            else:
                                 return "failed"
​
                    except requests.exceptions.HTTPError as errh:
                        return "failed"
                    except requests.exceptions.ConnectionError as errc:
                        return "failed"
                    except requests.exceptions.Timeout as errt:
                        return "failed"
                    except requests.exceptions.RequestException as err:
                        return "failed"
import sys 
import pandas as pd 
import json
import os
import numpy as np


#opening the json file
f = open(sys.argv[1]+".json", "r")
x=f.read()

# parse x:
data = json.loads(x)

# Creates DataFrame. 
df = pd.DataFrame(data)

df = df.fillna(value=np.nan)

f.close()
                   
#print(df)

df.to_stata(sys.argv[2]+'.dta', version=117)

#deleting the json file

os.remove(sys.argv[1]+".json") 

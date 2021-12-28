import sys 
import pandas as pd 
import numpy as np
import pyodbc

con_string = "driver={SQL SERVER}; server=172.29.29.37; database=hdss_testing; UID=sa; PWD=icddrb;"
cnxn = pyodbc.connect(con_string)
query = "SELECT* FROM "+sys.argv[1]
result_port_map = pd.read_sql(query, cnxn)

df = result_port_map.fillna(value=np.nan)

df.to_stata(sys.argv[1]+'.dta', version=117)


